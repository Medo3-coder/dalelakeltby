<script>
    $(document).on('click' , '.delete-row', function (e) {
        e.preventDefault()
        let url = $(this).data('url');
        Swal.fire({
            title: "{{ __('admin.sure_want_toc_continue_delete_med') }}",
            type: 'warning',
            icon: 'info',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: '{{__('admin.confirm')}}',
            confirmButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            }).then( (result) => {
            if (result.value) {
                $.ajax({
                    type: "delete",
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: (response) => {
                        toastr.remove()
                        toastr.success('{{ __('apis.deleted') }}');
                        $(this).parent().parent().remove()
                    }
                });
            }
        })
    });
</script>