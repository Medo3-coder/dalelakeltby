 <!--start footer-->
 <footer id="gocontact">
     <div class="container">
         <div class="footer">
             <a href="#"><img src="imgs/Group1.png" alt="" /></a>
             <ul class="user-ul hide-m">
                 <li>
                     <a href="{{ route(request()->segment(1) . '.site') }}#goheadspe">{{ __('site.home') }}</a>
                 </li>
                 <li>
                     <a href="{{ route(request()->segment(1) . '.site') }}#gomain">{{ __('site.about_us') }}</a>
                 </li>
                 <li>
                     <a href="{{ route(request()->segment(1) . '.site') }}#gospecial">{{ __('site.our_features') }}</a>
                 </li>
                 <li>
                     <a href="{{ route(request()->segment(1) . '.site') }}#gocontact">{{ __('site.contact_us') }}</a>
                 </li>
             </ul>
             <ul class="socials">
                 @foreach ($socials as $social)
                     <li>
                         <a href="{{ $social->link }}"><img src="{{ $social->icon }}" alt="" /></a>
                     </li>
                 @endforeach


             </ul>
         </div>
     </div>
 </footer>
 <!--end footer-->
 <script src="{{ asset('site/js/jquery-3.5.1.min.js') }}"></script>
 <script src="{{ asset('site/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('site/js/owl.carousel.min.js') }}"></script>
 <script src="{{ asset('site/js/wow.min.js') }}"></script>
 <script src="{{ asset('js/alertify.min.js') }}"></script>
 <script src="{{ asset('site/js/main.js') }}"></script>
 <script>
     $(".owl-carousel").owlCarousel({
         loop: true,
         margin: 40,
         nav: true,
         dots: false,
         rtl: true,
         lazyLoad: true,

         center: true,
         navText: [

             "<span class='fa-solid fa-forward'></span>",
             "<span class='fa-solid fa-backward'></span>",
         ],

         responsive: {
             0: {
                 items: 1,
             },
             600: {
                 items: 3,
             },
             1000: {
                 items: 5,
             },
         },
     });
 </script>
 <script>
     new WOW().init();
 </script>
 <script>
     let nums = document.querySelectorAll(".stats-rel-num");
     console.log(nums);
     let starts = document.querySelector(".statictics");
     console.log(starts.offsetTop - 670);
     console.log(window.scrollY);
     let started = false;

     window.onscroll = function() {
         if (window.scrollY >= starts.offsetTop - 670) {
             if (!started) {
                 nums.forEach((num) => startCount(num));
             }
             started = true;
         }
     };

     function startCount(el) {
         let goal = el.dataset.goal;
         let count = setInterval(() => {
             el.textContent++;
             if (el.textContent == goal) {
                 clearInterval(count);
             }
         }, 1200 / goal);
     }
 </script>
 </body>

 </html>
