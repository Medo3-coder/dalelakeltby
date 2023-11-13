
<link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $(document).on('submit', '.form', function(e) {
            var old_content =  $(".submit-button").html();

            var timesCont = $('.times-cont');
            var check = true;

            if(timesCont.length > 0){

                $('.msg-error').remove();
                timesCont.each(function (key, value){
                    var from = $(this).find('.from-date');
                    var to = $(this).find('.to-date');
                    var msg = '';
                    if(from.val() == ''){
                        msg += 'يجب اختيار اوقات العمل من , ';
                    }

                    if(Date.parse('01/01/2011 '+ from.val()) > Date.parse('01/01/2011 '+ to.val())){

                        msg += 'توقيت النهاية يجب اني يكون اكبر من البداية , ';
                    }

                    if(to.val() == ''){

                        msg += 'يجب اختيار اوقات العمل الى , ';
                    }
                    if(msg != ''){
                        check = false;
                        $(this).append(`
                        <div class="alert alert-danger text-center msg-error">${msg}</div>
                    `)
                    }


                });

            }

            e.preventDefault();
            if(check == true) {
                var form = $(this);
                var url = form.attr('action')
                $(this).ajaxSubmit({
                    url: url,
                    beforeSend: function () {
                        old_content = form.find(".submit-button").html();
                        form.find(".submit-button").attr('disabled', true);
                    },
                    uploadProgress:function (event,position,total,percentComplete) {
                        form.find(".submit-button").text(percentComplete+'%');
                    },
                    success: (response) => {
                        form.find(".error_show").html('')
                        form.find('input').removeClass('border-danger');
                        form.find('select').removeClass('border-danger');
                        form.find('textarea').removeClass('border-danger');
                        form.find(".submit-button").html(old_content).attr('disabled', false)
                        if (response.status != 'success') {
                            if (response.hasOwnProperty('input')) {

                                form.find('error_' + response.input).append(`<span class="mt-5 text-danger">${response.msg}</span>`);
                                $('.form input[name^=' + response.input + ']' + '.form select[name^=' + response.input + ']' + '.form textarea[name^=' + response.input + ']').addClass('border-danger')
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    iconColor: '#ff0000',
                                    title: '<h5 class="font_bold">'+ response.msg +'</h5>',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                iconColor: '#2f71b3',
                                title: '<h5 class="font_bold">'+ response.msg +'</h5>',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }

                        if (response.hasOwnProperty('url')) {
                            setTimeout(function () {
                                window.location.replace(response.url)
                            }, 1000);
                        }
                    },
                    error: function (xhr) {
                        form.find('.text-danger').remove();
                        form.find(".error_show").html('')
                        form.find('input').removeClass('border-danger');
                        form.find('select').removeClass('border-danger');
                        form.find('textarea').removeClass('border-danger');
                        form.find(".submit-button").html(old_content).attr('disabled', false)
                        var firstValidation = Object.keys(xhr.responseJSON.errors)[0];
                        var attr = $('[name="' + firstValidation + '"]');
                        var dataName = $('[data-name="' + firstValidation + '"]')
                        var id;
                        if (attr.length > 0) {
                            id = attr.parents('.tab-pane').attr('id');
                            $('[aria-controls="' + id + '"]').click();
                        }

                        if (dataName.length > 0) {
                            id = dataName.parents('.tab-pane').attr('id');
                            $('[aria-controls="' + id + '"]').click();
                        }





                        $.each(xhr.responseJSON.errors, function (key, value) {
                            $('[data-name="' + key + '"]').append(`<span class="text-danger d-block">${value}</span>`);
                            if (key.indexOf(".") >= 0) {
                                var slice = key.slice('0', 6);
                                var split = key.split('.')
                                key = split[0] + '\\[' + split[1] + '\\]';
                                if(slice == 'images'){
                                    key = split[0];
                                }
                            }

                            $('.form .error_' + key).append(`<span class="text-danger d-block">${value}</span>`);
                            $('[name^=' + key + ']').addClass('border-danger')

                        });
                    },
                });
            }else {
                $('[aria-controls="' + 'step2' + '"]').click();
            }

        });
    });
</script>
<script src="{{asset('admin/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>


