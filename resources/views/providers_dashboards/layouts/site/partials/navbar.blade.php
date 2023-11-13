   <!--start header-->
   <section class="header">
       <div class="container">
           <div class="user-header">
               <div class="logo">
                   <a href="{{ route(request()->segment(1) . '.site') }}"><img src="{{ $settings['logo'] }}"
                           alt="logo" /></a>
               </div>

               <div class="flex-logins">
                   <ul class="user-ul">
                       <li>
                           <a href="{{ route(request()->segment(1) . '.site') }}#goheadspe">{{ __('site.home') }}</a>
                       </li>
                       <li>
                           <a href="{{ route(request()->segment(1) . '.site') }}#gomain">{{ __('site.about_us') }}</a>
                       </li>
                       <li>
                           <a
                               href="{{ route(request()->segment(1) . '.site') }}#gospecial">{{ __('site.our_features') }}</a>
                       </li>
                       <li>
                           <a
                               href="{{ route(request()->segment(1) . '.site') }}#gocontact">{{ __('site.contact_us') }}</a>
                       </li>
                   </ul>
                   <div class="logins">

                       @if (!in_array(request()->segment(2), ['choose-login', 'login']))
                           <a class="header-btn up first-log"
                               href="{{ route(request()->segment(1) . '.chooseLogin') }}">{{ __('site.login') }}
                               {{ __('site.' . request()->segment(1)) }}</a>
                       @endif

                       @if (request()->segment(2) != 'register')
                           <a class="header-btn up second-log no-border"
                               href="{{ route(request()->segment(1) . '.register') }}">{{ __('site.create_account') }}
                               {{ __('site.' . request()->segment(1)) }}</a>
                       @endif
                   </div>
               </div>
               <div class="header-language">

                   @switch(lang())
                       @case('en')
                       <img src="{{ asset('site/imgs/en.png') }}" alt="lang" />
                       @break

                       @default
                       <img src="{{ asset('site/imgs/Group81304.png') }}" alt="lang" />

                   @endswitch

                   <div class="drop-header">
                       {{ __('site.' . lang()) }}
                       <i class="fa-solid fa-chevron-down"></i>
                       <div class="drop-down-lang">
                           <ul>
                               <li><a href="{{ route('lang', 'ar') }}"> {{ __('site.ar') }}
                                   </a></li>
                               <li><a href="{{ route('lang', 'en') }}"> {{ __('site.en') }}
                                   </a></li>
                               <li><a href="{{ route('lang', 'kur') }}"> {{ __('site.kur') }}
                                   </a></li>
                           </ul>
                       </div>
                   </div>
                   <div class="bars">
                       <span></span>
                       <span></span>
                       <span></span>
                   </div>
               </div>
           </div>
       </div>
   </section>
   <!--end header-->
