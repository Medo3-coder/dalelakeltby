@include('providers_dashboards.layouts.site.partials.header')

@include('providers_dashboards.layouts.site.partials.navbar')

@yield('content')

<script src="{{ asset('site/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('site/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('site/js/wow.min.js') }}"></script>
<script src="{{ asset('site/js/main.js') }}"></script>

<script src="{{ asset('/site/') }}/flag/build/js/intlTelInput.min.js"></script>

<script>
    var input = document.querySelector("#telephone");
    let iti = window.intlTelInput(input, {
        autoPlaceholder: "ادخل",
        customPlaceholder: "kggg",
        initialCountry: "iq",
        // nationalMode:false,
        separateDialCode: true,
    });

    var loadFiles = function(event) {
        var images = document.getElementById("change-profile");
        images.src = URL.createObjectURL(event.target.files[0]);
    };

    $('#country_code').val(iti.getSelectedCountryData()['dialCode'])
</script>

@yield('js')
@if (session()->has('success'))
    <script>
        toastr.success("{{ session()->get('success') }}")
    </script>
@elseif (session()->has('error'))
    <script>
        toastr.error("{{ session()->get('error') }}")
    </script>
@endif
<script>
    new WOW().init();
</script>
</body>

</html>
