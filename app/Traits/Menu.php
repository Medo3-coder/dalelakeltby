<?php

namespace App\Traits;

trait menu {
  public function home() {

    $menu = [
      [
        'name'  => __('admin.admins'),
        'count' => \App\Models\Admin::count(),
        'icon'  => 'fa-users',
        'url'   => url('admin/admins'),
      ], [
        'name'  => __('admin.doctors'),
        'count' => \App\Models\Doctor::count(),
        'icon'  => 'fa-user-md',
        'url'   => url('admin/doctors'),
      ], [
        'name'  => __('admin.labs'),
        'count' => \App\Models\Doctor::count(),
        'icon'  => 'fa-flask',
        'url'   => url('admin/labs'),
      ], [
        'name'  => __('admin.pharmacies'),
        'count' => \App\Models\Pharmacist::count(),
        'icon'  => 'fa fa-medkit',
        'url'   => url('admin/pharmacies'),
      ], [
        'name'  => __('admin.stores'),
        'count' => \App\Models\Store::count(),
        'icon'  => 'fa fa-shopping-basket',
        'url'   => url('admin/stores'),
      ], [
        'name'  => __('admin.users'),
        'count' => \App\Models\User::count(),
        'icon'  => 'fa-users',
        'url'   => url('admin/clients'),
      ], [
        'name'  => __('admin.labcategories'),
        'count' => \App\Models\LabCategory::count(),
        'icon'  => 'fa fa-th-list',
        'url'   => url('admin/labcategories/all'),
      ], [
        'name'  => __('admin.categories'),
        'count' => \App\Models\Category::count(),
        'icon'  => 'fa fa-th-list',
        'url'   => url('admin/categories'),
      ], [
        'name'  => __('admin.cities'),
        'count' => \App\Models\Country::count(),
        'icon'  => 'fa-globe',
        'url'   => url('admin/countries'),
      ], [
        'name'  => __('admin.countries'),
        'count' => \App\Models\City::count(),
        'icon'  => 'fa-globe',
        'url'   => url('admin/cities'),
      ], [
        'name'  => __('admin.targetbodyareas'),
        'count' => \App\Models\TargetBodyArea::count(),
        'icon'  => 'fa-list',
        'url'   => url('admin/targetbodyareas'),
      ], [
        'name'  => __('admin.bloodtypes'),
        'count' => \App\Models\BloodType::count(),
        'icon'  => 'fa-eyedropper',
        'url'   => url('admin/bloodtypes'),
      ], [
        'name'  => __('admin.chranicdiseases'),
        'count' => \App\Models\ChranicDisease::count(),
        'icon'  => 'fa-heartbeat',
        'url'   => url('admin/chranicdiseases'),
      ], [
        'name'  => __('admin.reservations'),
        'count' => \App\Models\Reservation::count(),
        'icon'  => 'fa-credit-card',
        'url'   => url('admin/reservations'),
      ], [
        'name'  => __('admin.orders'),
        'count' => \App\Models\Order::count(),
        'icon'  => 'fa-credit-card',
        'url'   => url('admin/orders'),
      ], [
        'name'  => __('admin.medicaladvices'),
        'count' => \App\Models\MedicalAdvice::count(),
        'icon'  => 'fa-lightbulb-o',
        'url'   => url('admin/medicaladvices'),
      ], [
        'name'  => __('admin.socials'),
        'count' => \App\Models\Social::count(),
        'icon'  => 'fa-thumbs-up',
        'url'   => url('admin/socials'),
      ], [
        'name'  => __('admin.complaints_and_proposals'),
        'count' => \App\Models\Complaint::count(),
        'icon'  => 'fa-flag',
        'url'   => url('admin/all-complaints'),
      ], [
        'name'  => __('admin.reports'),
        'count' => \App\Models\LogActivity::count(),
        'icon'  => 'fa-flag',
        'url'   => url('admin/reports'),
      ], [
        'name'  => __("admin.common_questions"),
        'count' => \App\Models\Fqs::count(),
        'icon'  => 'fa-question-circle',
        'url'   => url('admin/fqs'),
      ], [
        'name'  => __('admin.definition_pages'),
        'count' => \App\Models\Intro::count(),
        'icon'  => 'fa-file',
        'url'   => url('admin/intros'),
      ], [
        'name'  => __('admin.advertising_banners'),
        'count' => \App\Models\Image::count(),
        'icon'  => 'fa-image',
        'url'   => url('admin/images'),
      ], [
        'name'  => __('admin.message_packages'),
        'count' => \App\Models\SMS::count(),
        'icon'  => 'fa-envelope',
        'url'   => url('admin/sms'),
      ], [
        'name'  => __('admin.Validities'),
        'count' => \App\Models\Role::count(),
        'icon'  => 'fa-eye',
        'url'   => url('admin/roles'),
      ],
    ];

    return $menu;
  }

  public function introSiteCards() {
    $menu = [
      [
        'name'  => __('admin.insolder'),
        'count' => \App\Models\IntroSlider::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introsliders'),
      ],
      [
        'name'  => __('admin.Service_Suite'),
        'count' => \App\Models\IntroService::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introservices'),
      ],
      [
        'name'  => __('admin.questions_sections'),
        'count' => \App\Models\IntroFqsCategory::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introfqscategories'),
      ],
      [
        'name'  => __('admin.common_questions'),
        'count' => \App\Models\IntroFqs::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introfqs'),
      ],
      [
        'name'  => __('admin.Success_Partners'),
        'count' => \App\Models\IntroPartener::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introparteners'),
      ],
      [
        'name'  => __('admin.Customer_messages'),
        'count' => \App\Models\IntroMessages::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/intromessages'),
      ],
      [
        'name'  => __('admin.socials'),
        'count' => \App\Models\IntroSocial::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introsocials'),
      ],
      [
        'name'  => __('admin.how_the_site_works_section'),
        'count' => \App\Models\IntroHowWork::count(),
        'icon'  => 'icon-users',
        'url'   => url('admin/introhowworks'),
      ],
    ];
    return $menu;
  }

}