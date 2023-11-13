<script>
    getData()

    function searchArray() {
        var searchArray = {};
        $('.search-input').each(function(key, input) {
            if (input.type == 'checkbox' && input.checked) {
                searchArray[$(this).attr('name')] = $(this).val();
            } else if (input.type != 'checkbox') {
                searchArray[$(this).attr('name')] = $(this).val();
            }
        });
        return searchArray
    }

    $(document).on('change', '.search-input', function(e) {
        e.preventDefault();
        getData({
            'searchArray': searchArray()
        })
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        getData({
            page: $(this).attr('href').split('page=')[1],
            'searchArray': searchArray()
        })
    });

    $('.table_loader').fadeOut('slow');


    function getData(array) {
        $.ajax({
            type: "get",
            url: "{{ $index_route }}",
            data: array,
            dataType: "json",
            cache: false,
            beforeSend: function() {
                $('.table_loader').fadeIn('slow');
            },
            success: function(response) {
                $('.table_content_append').html(response.html)
                $('.table_loader').fadeOut('slow');
            }
        });
    }

    $('.clean-input').on('click', function() {
        $(this).siblings('input').val(null);
        $(this).siblings('select').val(null);
        getData({
            'searchArray': searchArray()
        })
    });
</script>
