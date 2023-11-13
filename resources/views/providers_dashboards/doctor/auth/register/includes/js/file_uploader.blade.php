{{-- <div class="col-12">
    <input type="file" class="form-control " data-input="files" name="files[]" multiple>
    <div class="files_uploader_container  p-2" data-container="files" > </div>
</div> --}}


<script>
    var ua = navigator.userAgent.toLowerCase();
    let inputsFiles = {};
    let browserIsSafari = false;
    $('[data-input]').on('change', function(event) {
        let input = $(this).data('input');

        if (!$(this).attr('multiple')) {
            $(`[data-container="${input}"]`).html('');
        }

        if (ua.indexOf('safari') != -1) {
            if (ua.indexOf('chrome') > -1 || (parseInt(ua.split(' ')[11]?.split('version/')[1]) >=
                    16)) { /// if the browser not safari
                if (!!inputsFiles[input]) {
                    let files = new DataTransfer();
                    for (let i = 0; i < event.target.files.length; i++) {
                        files.items.add(event.target.files[i]);
                    }

                    if (!!$(this).attr('multiple')) {
                        for (let i = 0; i < inputsFiles[input].length; i++) {
                            files.items.add(inputsFiles[input][i]);
                        }
                    }

                    inputsFiles[input] = files.files;
                    $(`[data-container="${input}"]`).html('');
                } else {
                    inputsFiles[input] = event.target.files;
                }
                if (!!inputsFiles[input] && inputsFiles[input].length > 0) {
                    setHtmlPreview(inputsFiles[input], input);
                }
                event.target.files = inputsFiles[input];
            } else { // if the browser is old version of safari less than v16
                browserIsSafari = true;
                $(`[data-container="${input}"]`).html('');
                setHtmlPreview(event.target.files, input);
            }
        }
    });

    function setHtmlPreview(filesList, input) {
        for (let i = 0; i < filesList.length; i++) {
            const fileType = filesList[i].type.split("/")[0];
            if (fileType === "image") {
                let src = null;
                $(`[data-container="${input}"]`).append(
                    `<div class="file_"> <a data-fancybox="gallery" href="${URL.createObjectURL(filesList[i])}"> <img src="${URL.createObjectURL(filesList[i])}" alt=""> </a> <div class="btn remove_media" onclick="deleteFile(this ,'${filesList[i].name}' ,'${input}')"><ion-icon name="close-outline" role="img" class="md hydrated" aria-label="close outline"></ion-icon></div> </div>`
                );
            } else if (fileType === "video") {
                let src = URL.createObjectURL(filesList[i]);

                $(`[data-container="${input}"]`).append(`
                <div class="files_uploader_element" >
                        <div>
                            <video class="w-100" controls>
                                    <source src="${src}" type="video/mp4">
                            </video>
                        </div>
                            <div class="files_uploader_delete_file" onclick="deleteFile(this ,'${filesList[i].name}' ,'${input}')">
                                <i class="fa fa-trash"></i>
                            </div>
                    </div>`);
            } else {
                $(`[data-container="${input}"]`).append(
                    `<div class="file_"> <div class="docs_file"> <div class="d-flex flex-column align-items-center justify-content-center h-100 p-2"> <span class="font10">${ filesList[i].name}</span> <span><i class="far fa-file-pdf mr-1 ml-1"></i></span> </div> </div> <div class="btn remove_media" onclick="deleteFile(this ,'${filesList[i].name}' ,'${input}')"><ion-icon name="close-outline" role="img" class="md hydrated" aria-label="close outline"></ion-icon></div> </div>`
                    );
            }
        }
    }


    function deleteFile(ele, name, input) {
        let filesInput = $(`[data-input="${input}"]`)[0];
        let files = new DataTransfer();
        let deleted = null;
        for (let i = 0; i < filesInput.files.length; i++) {
            if (filesInput.files[i].name == name && deleted != name) {
                deleted = name;
                continue;
            }
            files.items.add(filesInput.files[i]);
        }
        filesInput.files = files.files;
        if (!browserIsSafari) {
            inputsFiles[input] = files.files;
        }
        $(ele).parent().remove();
    }

    $(function() {
        const inputs = $('[data-input]');
        for (let i = 0; i < inputs.length; i++) {
            const input = inputs[i].getAttribute('data-input');
            const container = document.querySelector(`[data-container="${input}"]`);
            let file = $(inputs[i]).data('file');
            if (!$(input).attr('multiple') && file) {
                if (['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'webg', 'svg', 'gif'].indexOf(file.split('.')[
                        1]) != -1) { // images extensions
                    $(container).html(`<div class="files_uploader_element" >
                        <div>
                            <div><img src="${file}" alt=""></div>
                        </div>
                    </div>`);
                } else if (['mp4', 'MP4', 'MPEG', 'mpeg', 'rmvb', 'JPEG', 'webm', 'mkv', 'wmv'].indexOf(file
                        .split('.')[1]) != -1) { // videos extensions
                    $(container).html(`

                    <div class="w-100">
                        <video class="w-100" controls>
                            <source src="${file}" type="video/mp4">
                        </video>
                    </div>`);
                }
            }
        }
    });
</script>
