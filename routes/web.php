<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'admin',
    'namespace'  => 'Admin',
    'as'         => 'admin.',
    'middleware' => ['web-cors'],
], function () {

    Route::get('/lang/{lang}', 'AuthController@SetLanguage');

    Route::get('login', 'AuthController@showLoginForm')->name('show.login')->middleware('guest:admin');
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('logout', 'AuthController@logout')->name('logout');

    Route::post('getCities', 'CityController@getCities')->name('getCities');

    Route::get('user_complaints/{id}', [
        'uses'  => 'ClientController@showfinancial',
        'as'    => 'user_complaints.show',
        'title' => 'the_resolution_of_complaining_or_proposal',
    ]);

    Route::get('user_orders/{id}', [
        'uses'  => 'ClientController@showorders',
        'as'    => 'user_orders.show',
        'title' => 'orders',
    ]);

    Route::group(['middleware' => ['admin', 'check-role', 'admin-lang']], function () {
        /*------------ start Of profile----------*/
        Route::get('profile', [
            'uses'      => 'HomeController@profile',
            'as'        => 'profile',
            'title'     => 'profile',
            'sub_route' => true,
            'type'      => 'parent',
            'child'     => ['profile.update_password', 'profile.update'],
        ]);

        Route::put('profile-update', [
            'uses'  => 'HomeController@updateProfile',
            'as'    => 'profile.update',
            'title' => 'update_profile',
        ]);
        Route::put('profile-update-password', [
            'uses'  => 'HomeController@updatePassword',
            'as'    => 'profile.update_password',
            'title' => 'update_password',
        ]);
        /*------------ end Of profile----------*/

        /*------------ start Of Dashboard----------*/
        Route::get('dashboard', [
            'uses'      => 'HomeController@dashboard',
            'as'        => 'dashboard',
            'icon'      => '<i class="feather icon-home"></i>',
            'title'     => 'main_page',
            'sub_route' => false,
            'type'      => 'parent',
        ]);
        /*------------ end Of dashboard ----------*/

        /*------------ start Of all categories  ----------*/
        Route::get('all-categories', [
            'as'        => 'all_categories',
            'icon'      => '<i class="feather icon-list"></i>',
            'title'     => 'categories',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'labcategories.index', 'labcategories.create', 'labcategories.store', 'labcategories.edit', 'labcategories.update', 'labcategories.show', 'labcategories.delete', 'labcategories.deleteAll',
                'categories.index', 'categories.export', 'categories.create', 'categories.store', 'categories.edit', 'categories.update', 'categories.delete', 'categories.deleteAll', 'categories.show',
            ],
        ]);

        /*------------ start Of labcategories ----------*/
        Route::get('labcategories/all/{parent_id?}', [
            'uses'  => 'LabCategoryController@index',
            'as'    => 'labcategories.index',
            'title' => 'labcategories',
            'icon'  => '<i class="fa fa-th-list"></i>',
        ]);

        # labcategories store
        Route::get('labcategories/create/{parent_id}', [
            'uses'  => 'LabCategoryController@create',
            'as'    => 'labcategories.create',
            'title' => 'add_labcategory_page',
        ]);

        # labcategories store
        Route::post('labcategories/store/{parent_id}', [
            'uses'  => 'LabCategoryController@store',
            'as'    => 'labcategories.store',
            'title' => 'add_labcategory',
        ]);

        # labcategories update
        Route::get('labcategories/{id}/edit', [
            'uses'  => 'LabCategoryController@edit',
            'as'    => 'labcategories.edit',
            'title' => 'update_labcategory_page',
        ]);

        # labcategories update
        Route::put('labcategories/{id}', [
            'uses'  => 'LabCategoryController@update',
            'as'    => 'labcategories.update',
            'title' => 'update_labcategory',
        ]);

        # labcategories show
        Route::get('labcategories/{id}/Show', [
            'uses'  => 'LabCategoryController@show',
            'as'    => 'labcategories.show',
            'title' => 'show_labcategory_page',
        ]);

        # labcategories delete
        Route::delete('labcategories/{id}', [
            'uses'  => 'LabCategoryController@destroy',
            'as'    => 'labcategories.delete',
            'title' => 'delete_labcategory',
        ]);
        #delete all labcategories
        Route::post('delete-all-labcategories', [
            'uses'  => 'LabCategoryController@destroyAll',
            'as'    => 'labcategories.deleteAll',
            'title' => 'delete_group_of_labcategories',
        ]);

        /*------------ end Of labcategories ----------*/

        /*------------ start Of categories ----------*/
        Route::get('categories-show/{id?}', [
            'uses'  => 'CategoryController@index',
            'as'    => 'categories.index',
            'title' => 'sections',
            'icon'  => '<i class="feather icon-list"></i>',
        ]);

        # categories store
        Route::get('categories/export', [
            'uses'  => 'CategoryController@export',
            'as'    => 'categories.export',
            'title' => ' export ',
        ]);
        # categories store
        Route::get('categories/create/{id?}', [
            'uses'  => 'CategoryController@create',
            'as'    => 'categories.create',
            'title' => 'add_section',
        ]);

        # categories store
        Route::post('categories/store', [
            'uses'  => 'CategoryController@store',
            'as'    => 'categories.store',
            'title' => 'add_section',
        ]);

        # categories update
        Route::get('categories/{id}/edit', [
            'uses'  => 'CategoryController@edit',
            'as'    => 'categories.edit',
            'title' => 'edit_section_page',
        ]);

        # categories update
        Route::put('categories/{id}', [
            'uses'  => 'CategoryController@update',
            'as'    => 'categories.update',
            'title' => 'edit_section',
        ]);

        Route::get('categories/{id}/show',
            [
                'uses'  => 'CategoryController@show',
                'as'    => 'categories.show',
                'title' => 'view_section',
            ]
        );

        # categories delete
        Route::delete('categories/{id}', [
            'uses'  => 'CategoryController@destroy',
            'as'    => 'categories.delete',
            'title' => 'delete_section',
        ]);
        #delete all categories
        Route::post('delete-all-categories', [
            'uses'  => 'CategoryController@destroyAll',
            'as'    => 'categories.deleteAll',
            'title' => 'delete_multible_section',
        ]);
        /*------------ end Of categories ----------*/

        /*------------ cities & countries ----------*/
//
//            Route::get('countries-cities', [
//                'as'        => 'countries-cities',
//                'icon'      => '<i class="feather icon-globe"></i>',
//                'title'     => 'countries_cities',
//                'type'      => 'parent',
//                'sub_route' => true,
//                'child'     => [
//                    'countries.index', 'countries.show', 'countries.create', 'countries.store', 'countries.edit', 'countries.update', 'countries.delete', 'countries.deleteAll',
//                    'cities.index', 'cities.create', 'cities.store', 'cities.edit', 'cities.show', 'cities.update', 'cities.delete', 'cities.deleteAll'
//                ],
//            ]);
//
//            /*------------ start Of countries ----------*/
//                Route::get('countries', [
//                    'uses'      => 'CountryController@index',
//                    'as'        => 'countries.index',
//                    'title'     => 'cities',
//                    'icon'      => '<i class="feather icon-flag"></i>',
//                ]);
//
//                Route::get('countries/{id}/show', [
//                    'uses'  => 'CountryController@show',
//                    'as'    => 'countries.show',
//                    'title' => 'view_country',
//                ]);
//
//                # countries store
//                Route::get('countries/create', [
//                    'uses'  => 'CountryController@create',
//                    'as'    => 'countries.create',
//                    'title' => 'add_country',
//                ]);
//
//                # countries store
//                Route::post('countries/store', [
//                    'uses'  => 'CountryController@store',
//                    'as'    => 'countries.store',
//                    'title' => 'add_country',
//                ]);
//
//                # countries update
//                Route::get('countries/{id}/edit', [
//                    'uses'  => 'CountryController@edit',
//                    'as'    => 'countries.edit',
//                    'title' => 'edit_country',
//                ]);
//
//                # countries update
//                Route::put('countries/{id}', [
//                    'uses'  => 'CountryController@update',
//                    'as'    => 'countries.update',
//                    'title' => 'edit_country',
//                ]);
//
//                # countries delete
//                Route::delete('countries/{id}', [
//                    'uses'  => 'CountryController@destroy',
//                    'as'    => 'countries.delete',
//                    'title' => 'delete_country',
//                ]);
//                #delete all countries
//                Route::post('delete-all-countries', [
//                    'uses'  => 'CountryController@destroyAll',
//                    'as'    => 'countries.deleteAll',
//                    'title' => 'delete_multible_country',
//                ]);
//            /*------------ end Of countries ----------*/

            /*------------ start Of cities ----------*/
                Route::get('cities', [
                    'uses'      => 'CityController@index',
                    'as'        => 'cities.index',
                    'title'     => 'countries',
                    'icon'      => '<i class="feather icon-globe"></i>',
                    'type'      => 'parent',
                    'child'     => [
                        'cities.index', 'cities.create', 'cities.store', 'cities.edit', 'cities.show', 'cities.update', 'cities.delete', 'cities.deleteAll'
                    ],
                ]);

                # cities store
                Route::get('cities/create', [
                    'uses'  => 'CityController@create',
                    'as'    => 'cities.create',
                    'title' => 'add_city',
                ]);

                # cities store
                Route::post('cities/store', [
                    'uses'  => 'CityController@store',
                    'as'    => 'cities.store',
                    'title' => 'add_city',
                ]);

                # cities update
                Route::get('cities/{id}/edit', [
                    'uses'  => 'CityController@edit',
                    'as'    => 'cities.edit',
                    'title' => 'edit_city',
                ]);

                # cities update
                Route::put('cities/{id}',
                    [
                        'uses'  => 'CityController@update',
                        'as'    => 'cities.update',
                        'title' => 'edit_city',
                    ]
                );

                Route::get('cities/{id}/show', [
                    'uses'  => 'CityController@show',
                    'as'    => 'cities.show',
                    'title' => 'view_city',
                ]);

                # cities delete
                Route::delete('cities/{id}', [
                    'uses'  => 'CityController@destroy',
                    'as'    => 'cities.delete',
                    'title' => 'delete_city',
                ]);
                #delete all cities
                Route::post('delete-all-cities', [
                    'uses'  => 'CityController@destroyAll',
                    'as'    => 'cities.deleteAll',
                    'title' => 'delete_multible_city',
                ]);
        /*------------ end Of cities ----------*/

        /*------------ public features  ----------*/
        Route::get('public-features', [
            'as'        => 'public-features',
            'icon'      => '<i class="feather icon-list"></i>',
            'title'     => 'public_features',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                "targetbodyareas.index", 'targetbodyareas.create', 'targetbodyareas.store', 'targetbodyareas.edit', 'targetbodyareas.update', 'targetbodyareas.show', 'targetbodyareas.delete', 'targetbodyareas.deleteAll',
                'bloodtypes.index', 'bloodtypes.create', 'bloodtypes.store', 'bloodtypes.edit', 'bloodtypes.update', 'bloodtypes.show', 'bloodtypes.delete', 'bloodtypes.deleteAll',
                'chranicdiseases.index', 'chranicdiseases.create', 'chranicdiseases.store', 'chranicdiseases.edit', 'chranicdiseases.update', 'chranicdiseases.show', 'chranicdiseases.delete', 'chranicdiseases.deleteAll',
            ],
        ]);

        /*------------ start of tareget body ----------*/

        Route::get('targetbodyareas/all', [
            'uses'  => 'TargetBodyAreaController@index',
            'as'    => 'targetbodyareas.index',
            'title' => 'targetbodyareas',
            'icon'  => '<i class="fa fa-child"></i>',
        ]);

        # targetbodyareas store
        Route::get('targetbodyareas/create', [
            'uses'  => 'TargetBodyAreaController@create',
            'as'    => 'targetbodyareas.create',
            'title' => 'add_targetbodyarea_page',
        ]);

        # targetbodyareas store
        Route::post('targetbodyareas/store', [
            'uses'  => 'TargetBodyAreaController@store',
            'as'    => 'targetbodyareas.store',
            'title' => 'add_targetbodyarea',
        ]);

        # targetbodyareas update
        Route::get('targetbodyareas/{id}/edit', [
            'uses'  => 'TargetBodyAreaController@edit',
            'as'    => 'targetbodyareas.edit',
            'title' => 'update_targetbodyarea_page',
        ]);

        # targetbodyareas update
        Route::put('targetbodyareas/{id}', [
            'uses'  => 'TargetBodyAreaController@update',
            'as'    => 'targetbodyareas.update',
            'title' => 'update_targetbodyarea',
        ]);

        # targetbodyareas show
        Route::get('targetbodyareas/{id}/Show', [
            'uses'  => 'TargetBodyAreaController@show',
            'as'    => 'targetbodyareas.show',
            'title' => 'show_targetbodyarea_page',
        ]);

        # targetbodyareas delete
        Route::delete('targetbodyareas/{id}', [
            'uses'  => 'TargetBodyAreaController@destroy',
            'as'    => 'targetbodyareas.delete',
            'title' => 'delete_targetbodyarea',
        ]);
        #delete all targetbodyareas
        Route::post('delete-all-targetbodyareas', [
            'uses'  => 'TargetBodyAreaController@destroyAll',
            'as'    => 'targetbodyareas.deleteAll',
            'title' => 'delete_group_of_targetbodyareas',
        ]);

        /*------------ end of tareget body ----------*/

        /*------------ start Of bloodtypes ----------*/
        Route::get('bloodtypes', [
            'uses'  => 'BloodTypeController@index',
            'as'    => 'bloodtypes.index',
            'title' => 'bloodtypes',
            'icon'  => '<i class="fa fa-eyedropper"></i>',
        ]);

        # bloodtypes store
        Route::get('bloodtypes/create', [
            'uses'  => 'BloodTypeController@create',
            'as'    => 'bloodtypes.create',
            'title' => 'add_bloodtype_page',
        ]);

        # bloodtypes store
        Route::post('bloodtypes/store', [
            'uses'  => 'BloodTypeController@store',
            'as'    => 'bloodtypes.store',
            'title' => 'add_bloodtype',
        ]);

        # bloodtypes update
        Route::get('bloodtypes/{id}/edit', [
            'uses'  => 'BloodTypeController@edit',
            'as'    => 'bloodtypes.edit',
            'title' => 'update_bloodtype_page',
        ]);

        # bloodtypes update
        Route::put('bloodtypes/{id}', [
            'uses'  => 'BloodTypeController@update',
            'as'    => 'bloodtypes.update',
            'title' => 'update_bloodtype',
        ]);

        # bloodtypes show
        Route::get('bloodtypes/{id}/Show', [
            'uses'  => 'BloodTypeController@show',
            'as'    => 'bloodtypes.show',
            'title' => 'show_bloodtype_page',
        ]);

        # bloodtypes delete
        Route::delete('bloodtypes/{id}', [
            'uses'  => 'BloodTypeController@destroy',
            'as'    => 'bloodtypes.delete',
            'title' => 'delete_bloodtype',
        ]);
        #delete all bloodtypes
        Route::post('delete-all-bloodtypes', [
            'uses'  => 'BloodTypeController@destroyAll',
            'as'    => 'bloodtypes.deleteAll',
            'title' => 'delete_group_of_bloodtypes',
        ]);
        /*------------ end Of bloodtypes ----------*/

        /*------------ start Of chranicdiseases ----------*/
        Route::get('chranicdiseases', [
            'uses'  => 'ChranicDiseasesController@index',
            'as'    => 'chranicdiseases.index',
            'title' => 'chranicdiseases',
            'icon'  => '<i class="fa fa-heartbeat"></i>',
        ]);

        # chranicdiseases store
        Route::get('chranicdiseases/create', [
            'uses'  => 'ChranicDiseasesController@create',
            'as'    => 'chranicdiseases.create',
            'title' => 'add_chranicdiseases_page',
        ]);

        # chranicdiseases store
        Route::post('chranicdiseases/store', [
            'uses'  => 'ChranicDiseasesController@store',
            'as'    => 'chranicdiseases.store',
            'title' => 'add_chranicdiseases',
        ]);

        # chranicdiseases update
        Route::get('chranicdiseases/{id}/edit', [
            'uses'  => 'ChranicDiseasesController@edit',
            'as'    => 'chranicdiseases.edit',
            'title' => 'update_chranicdiseases_page',
        ]);

        # chranicdiseases update
        Route::put('chranicdiseases/{id}', [
            'uses'  => 'ChranicDiseasesController@update',
            'as'    => 'chranicdiseases.update',
            'title' => 'update_chranicdiseases',
        ]);

        # chranicdiseases show
        Route::get('chranicdiseases/{id}/Show', [
            'uses'  => 'ChranicDiseasesController@show',
            'as'    => 'chranicdiseases.show',
            'title' => 'show_chranicdiseases_page',
        ]);

        # chranicdiseases delete
        Route::delete('chranicdiseases/{id}', [
            'uses'  => 'ChranicDiseasesController@destroy',
            'as'    => 'chranicdiseases.delete',
            'title' => 'delete_chranicdiseases',
        ]);
        #delete all chranicdiseases
        Route::post('delete-all-chranicdiseases', [
            'uses'  => 'ChranicDiseasesController@destroyAll',
            'as'    => 'chranicdiseases.deleteAll',
            'title' => 'delete_group_of_chranicdiseases',
        ]);
        /*------------ end Of chranicdiseases ----------*/

        /*------------ public features  ----------*/

        /*------------ users  & admins  ----------*/

        Route::get('users-admins', [
            'as'        => 'users-admins',
            'icon'      => '<i class="feather icon-users"></i>',
            'title'     => 'users_admins',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'clients.index', 'clients.show', 'clients.block', 'clients.store', 'clients.update', 'clients.delete', 'clients.notify', 'clients.deleteAll', 'clients.create', 'clients.edit',
                'admins.index', 'admins.block', 'admins.store', 'admins.update', 'admins.edit', 'admins.delete', 'admins.deleteAll', 'admins.create', 'admins.edit', 'admins.notifications', 'admins.notifications.delete', 'admins.show',
            ],
        ]);
        /*------------ start Of users Controller ----------*/
        Route::get('clients', [
            'uses'  => 'ClientController@index',
            'as'    => 'clients.index',
            'icon'  => '<i class="feather icon-users"></i>',
            'title' => 'users',
        ]);

        # clients store
        Route::get('clients/create', [
            'uses'  => 'ClientController@create',
            'as'    => 'clients.create', 'clients.edit',
            'title' => 'add_client',
        ]);

        # clients update
        Route::get('clients/{id}/edit', [
            'uses'  => 'ClientController@edit',
            'as'    => 'clients.edit',
            'title' => 'edit_client',
        ]);
        #store
        Route::post('clients/store', [
            'uses'  => 'ClientController@store',
            'as'    => 'clients.store',
            'title' => 'add_client',
        ]);
        #block
        Route::post('clients/block', [
            'uses'  => 'ClientController@block',
            'as'    => 'clients.block',
            'title' => 'block_client',
        ]);

        #update
        Route::put('clients/{id}', [
            'uses'  => 'ClientController@update',
            'as'    => 'clients.update',
            'title' => 'edit_client',
        ]);

        Route::get('clients/{id}/show', [
            'uses'  => 'ClientController@show',
            'as'    => 'clients.show',
            'title' => 'view_user',
        ]);

        #delete
        Route::delete('clients/{id}', [
            'uses'  => 'ClientController@destroy',
            'as'    => 'clients.delete',
            'title' => 'delete_user',
        ]);

        #delete
        Route::post('delete-all-clients',
            [
                'uses'  => 'ClientController@destroyAll',
                'as'    => 'clients.deleteAll',
                'title' => 'delete_multible_user',
            ]
        );

        #notify
        Route::post('admins/clients/notify', [
            'uses'  => 'ClientController@notify',
            'as'    => 'clients.notify',
            'title' => 'Send_user_notification',
        ]);
        /*------------ end Of users Controller ----------*/

        /************ Admins ************/
        #index
        Route::get('admins', [
            'uses'  => 'AdminController@index',
            'as'    => 'admins.index',
            'title' => 'admins',
            'icon'  => '<i class="feather icon-users"></i>',
        ]);

        # admins store
        Route::get('show-notifications', [
            'uses'  => 'AdminController@notifications',
            'as'    => 'admins.notifications',
            'title' => 'notification_page',
        ]);

        #block
        Route::post('admins/block', [
            'uses'  => 'AdminController@block',
            'as'    => 'admins.block',
            'title' => 'block_admin',
        ]);

        # admins store
        Route::post('delete-notifications', [
            'uses'  => 'AdminController@deleteNotifications',
            'as'    => 'admins.notifications.delete',
            'title' => 'delete_notification',
        ]);

        # admins store
        Route::get('admins/create', [
            'uses'  => 'AdminController@create',
            'as'    => 'admins.create',
            'title' => 'add_admin',
        ]);

        #store
        Route::post('admins/store', [
            'uses'  => 'AdminController@store',
            'as'    => 'admins.store',
            'title' => 'add_admin',
        ]);

        # admins update
        Route::get('admins/{id}/edit', [
            'uses'  => 'AdminController@edit',
            'as'    => 'admins.edit',
            'title' => 'edit_admin',
        ]);
        #update
        Route::put('admins/{id}', [
            'uses'  => 'AdminController@update',
            'as'    => 'admins.update',
            'title' => 'edit_admin',
        ]);

        Route::get('admins/{id}/show', [
            'uses'  => 'AdminController@show',
            'as'    => 'admins.show',
            'title' => 'view_admin',
        ]);

        #delete
        Route::delete('admins/{id}', [
            'uses'  => 'AdminController@destroy',
            'as'    => 'admins.delete',
            'title' => 'delete_admin',
        ]);

        #delete
        Route::post('delete-all-admins',
            [
                'uses'  => 'AdminController@destroyAll',
                'as'    => 'admins.deleteAll',
                'title' => 'delete_multible_admin',
            ]
        );

        /************ #Admins ************/
        /*------------ cities & countries ----------*/

        /*------------ start Of intro site  ----------*/
        Route::get('intro-site', [
            'as'        => 'intro_site',
            'icon'      => '<i class="feather icon-globe"></i>',
            'title'     => 'introductory_site',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'intro_settings.index', 'introsliders.show', 'introsliders.index', 'introsliders.store', 'introsliders.update', 'introsliders.delete', 'introsliders.deleteAll', 'introsliders.create', 'introsliders.edit',
                'introservices.show', 'introservices.index', 'introservices.create', 'introservices.store', 'introservices.edit', 'introservices.update', 'introservices.delete', 'introservices.deleteAll',
                'introfqscategories.show', 'introfqscategories.index', 'introfqscategories.store', 'introfqscategories.create', 'introfqscategories.edit', 'introfqscategories.update', 'introfqscategories.delete', 'introfqscategories.deleteAll',
                'introfqs.show', 'introfqs.index', 'introfqs.store', 'introfqs.update', 'introfqs.delete', 'introfqs.deleteAll', 'introfqs.edit', 'introfqs.create',
                'introparteners.create', 'introparteners.show', 'introparteners.index', 'introparteners.store', 'introparteners.update', 'introparteners.delete', 'introparteners.deleteAll',
                'intromessages.index', 'intromessages.delete', 'intromessages.deleteAll', 'intromessages.show',
                'introsocials.show', 'introsocials.index', 'introsocials.store', 'introsocials.update', 'introsocials.delete', 'introsocials.deleteAll', 'introsocials.edit', 'introsocials.create',
                'introparteners.edit', 'introhowworks.show', 'introhowworks.index', 'introhowworks.store', 'introhowworks.update', 'introhowworks.delete', 'introhowworks.deleteAll', 'introhowworks.create', 'introhowworks.edit',
            ],
        ]);

        Route::get('intro-settings', [
            'uses'  => 'IntroSetting@index',
            'as'    => 'intro_settings.index',
            'title' => 'introductory_site_setting',
            'icon'  => '<i class="feather icon-settings"></i>',

        ]);

        /*------------ start Of introsliders ----------*/
        Route::get('introsliders', [
            'uses'  => 'IntroSliderController@index',
            'as'    => 'introsliders.index',
            'title' => 'insolder',
            'icon'  => '<i class="feather icon-image"></i>',
        ]);

        # introsliders update
        Route::get('introsliders/{id}/Show', [
            'uses'  => 'IntroSliderController@show',
            'as'    => 'introsliders.show',
            'title' => 'view_of_banner_page',
        ]);

        # socials store
        Route::get('introsliders/create', [
            'uses'  => 'IntroSliderController@create',
            'as'    => 'introsliders.create',
            'title' => 'add_of_banner_page',
        ]);

        # introsliders store
        Route::post('introsliders/store', [
            'uses'  => 'IntroSliderController@store',
            'as'    => 'introsliders.store',
            'title' => 'add_a_banner',
        ]);

        # socials update
        Route::get('introsliders/{id}/edit', [
            'uses'  => 'IntroSliderController@edit',
            'as'    => 'introsliders.edit',
            'title' => 'edit_of_banner_page',
        ]);

        # introsliders update
        Route::put('introsliders/{id}', [
            'uses'  => 'IntroSliderController@update',
            'as'    => 'introsliders.update',
            'title' => 'modification_of_banner',
        ]);

        # introsliders delete
        Route::delete('introsliders/{id}', [
            'uses'  => 'IntroSliderController@destroy',
            'as'    => 'introsliders.delete',
            'title' => 'delete_a_banner',
        ]);

        #delete all introsliders
        Route::post('delete-all-introsliders', [
            'uses'  => 'IntroSliderController@destroyAll',
            'as'    => 'introsliders.deleteAll',
            'title' => 'delete_multible_banner',
        ]);
        /*------------ end Of introsliders ----------*/

        /*------------ start Of introservices ----------*/
        Route::get('introservices', [
            'uses'  => 'IntroServiceController@index',
            'as'    => 'introservices.index',
            'title' => 'our_services',
            'icon'  => '<i class="la la-map"></i>',
        ]);
        # introservices update
        Route::get('introservices/{id}/Show', [
            'uses'  => 'IntroServiceController@show',
            'as'    => 'introservices.show',
            'title' => 'view_services',
        ]);
        # socials store
        Route::get('introservices/create', [
            'uses'  => 'IntroServiceController@create',
            'as'    => 'introservices.create',
            'title' => 'add_services',
        ]);
        # introservices store
        Route::post('introservices/store', [
            'uses'  => 'IntroServiceController@store',
            'as'    => 'introservices.store',
            'title' => 'add_services',
        ]);

        # socials update
        Route::get('introservices/{id}/edit', [
            'uses'  => 'IntroServiceController@edit',
            'as'    => 'introservices.edit',
            'title' => 'edit_services',
        ]);

        # introservices update
        Route::put('introservices/{id}', [
            'uses'  => 'IntroServiceController@update',
            'as'    => 'introservices.update',
            'title' => 'edit_services',
        ]);

        # introservices delete
        Route::delete('introservices/{id}', [
            'uses'  => 'IntroServiceController@destroy',
            'as'    => 'introservices.delete',
            'title' => 'delete_services',
        ]);

        #delete all introservices
        Route::post('delete-all-introservices', [
            'uses'  => 'IntroServiceController@destroyAll',
            'as'    => 'introservices.deleteAll',
            'title' => 'delete_multible_services',
        ]);
        /*------------ end Of introservices ----------*/

        /*------------ start Of introfqscategories ----------*/
        Route::get('introfqscategories', [
            'uses'  => 'IntroFqsCategoryController@index',
            'as'    => 'introfqscategories.index',
            'title' => 'common_questions',
            'icon'  => '<i class="la la-list"></i>',
        ]);
        # socials store
        Route::get('introfqscategories/create', [
            'uses'  => 'IntroFqsCategoryController@create',
            'as'    => 'introfqscategories.create',
            'title' => 'add_Common_questions_section',
        ]);
        # introfqscategories store
        Route::post('introfqscategories/store', [
            'uses'  => 'IntroFqsCategoryController@store',
            'as'    => 'introfqscategories.store',
            'title' => 'add_secjtrjtrjtrjtrjtrtion',
        ]);
        # introfqscategories update
        Route::get('introfqscategories/{id}/edit', [
            'uses'  => 'IntroFqsCategoryController@edit',
            'as'    => 'introfqscategories.edit',
            'title' => 'edit_section_page',
        ]);
        # introfqscategories update
        Route::put('introfqscategories/{id}', [
            'uses'  => 'IntroFqsCategoryController@update',
            'as'    => 'introfqscategories.update',
            'title' => 'edit_section',
        ]);

        # introfqscategories update
        Route::get('introfqscategories/{id}/Show', [
            'uses'  => 'IntroFqsCategoryController@show',
            'as'    => 'introfqscategories.show',
            'title' => 'view_section_page',
        ]);

        # introfqscategories delete
        Route::delete('introfqscategories/{id}', [
            'uses'  => 'IntroFqsCategoryController@destroy',
            'as'    => 'introfqscategories.delete',
            'title' => 'delete_section',
        ]);

        #delete all introfqscategories
        Route::post('delete-all-introfqscategories', [
            'uses'  => 'IntroFqsCategoryController@destroyAll',
            'as'    => 'introfqscategories.deleteAll',
            'title' => 'delete_multible_section ',
        ]);
        /*------------ end Of introfqscategories ----------*/

        /*------------ start Of introfqs ----------*/
        Route::get('introfqs', [
            'uses'  => 'IntroFqsController@index',
            'as'    => 'introfqs.index',
            'title' => 'questions_sections',
            'icon'  => '<i class="la la-bullhorn"></i>',
        ]);

        # socials store
        Route::get('introfqs/create', [
            'uses'  => 'IntroFqsController@create',
            'as'    => 'introfqs.create',
            'title' => 'add_question',
        ]);

        # introfqs store
        Route::post('introfqs/store', [
            'uses'  => 'IntroFqsController@store',
            'as'    => 'introfqs.store',
            'title' => 'add_question',
        ]);
        # introfqscategories update
        Route::get('introfqs/{id}/edit', [
            'uses'  => 'IntroFqsController@edit',
            'as'    => 'introfqs.edit',
            'title' => 'edit_question',
        ]);
        # introfqscategories update
        Route::get('introfqs/{id}/Show', [
            'uses'  => 'IntroFqsController@show',
            'as'    => 'introfqs.show',
            'title' => 'view_question',
        ]);

        # introfqs update
        Route::put('introfqs/{id}', [
            'uses'  => 'IntroFqsController@update',
            'as'    => 'introfqs.update',
            'title' => 'edit_question',
        ]);

        # introfqs delete
        Route::delete('introfqs/{id}', [
            'uses'  => 'IntroFqsController@destroy',
            'as'    => 'introfqs.delete',
            'title' => 'delete_question',
        ]);

        #delete all introfqs
        Route::post('delete-all-introfqs', [
            'uses'  => 'IntroFqsController@destroyAll',
            'as'    => 'introfqs.deleteAll',
            'title' => 'delete_multible_question',
        ]);
        /*------------ end Of introfqs ----------*/

        /*------------ start Of introparteners ----------*/
        Route::get('introparteners', [
            'uses'  => 'IntroPartenerController@index',
            'as'    => 'introparteners.index',
            'title' => 'Success_Partners',
            'icon'  => '<i class="la la-list"></i>',
        ]);

        # introparteners update
        Route::get('introparteners/{id}/Show', [
            'uses'  => 'IntroPartenerController@show',
            'as'    => 'introparteners.show',
            'title' => 'view_partner_success',
        ]);

        # socials store
        Route::get('introparteners/create', [
            'uses'  => 'IntroPartenerController@create',
            'as'    => 'introparteners.create',
            'title' => 'add_partner',
        ]);

        # introparteners store
        Route::post('introparteners/store', [
            'uses'  => 'IntroPartenerController@store',
            'as'    => 'introparteners.store',
            'title' => 'add_partner',
        ]);

        # introparteners update
        Route::get('introparteners/{id}/edit', [
            'uses'  => 'IntroPartenerController@edit',
            'as'    => 'introparteners.edit',
            'title' => 'edit_partner',
        ]);

        # introparteners update
        Route::put('introparteners/{id}', [
            'uses'  => 'IntroPartenerController@update',
            'as'    => 'introparteners.update',
            'title' => 'edit_partner',
        ]);

        # introparteners delete
        Route::delete('introparteners/{id}', [
            'uses'  => 'IntroPartenerController@destroy',
            'as'    => 'introparteners.delete',
            'title' => 'delete_partner',
        ]);

        #delete all introparteners
        Route::post('delete-all-introparteners', [
            'uses'  => 'IntroPartenerController@destroyAll',
            'as'    => 'introparteners.deleteAll',
            'title' => 'delete_multible_partner',
        ]);
        /*------------ end Of introparteners ----------*/

        /*------------ start Of intromessages ----------*/
        Route::get('intromessages', [
            'uses'  => 'IntroMessagesController@index',
            'as'    => 'intromessages.index',
            'title' => 'Customer_messages',
            'icon'  => '<i class="la la-envelope-square"></i>',
        ]);

        # socials update
        Route::get('intromessages/{id}', [
            'uses'  => 'IntroMessagesController@show',
            'as'    => 'intromessages.show',
            'title' => 'view_message',
        ]);

        # intromessages delete
        Route::delete('intromessages/{id}', [
            'uses'  => 'IntroMessagesController@destroy',
            'as'    => 'intromessages.delete',
            'title' => 'delete_message',
        ]);

        #delete all intromessages
        Route::post('delete-all-intromessages', [
            'uses'  => 'IntroMessagesController@destroyAll',
            'as'    => 'intromessages.deleteAll',
            'title' => 'delete_multible_message',
        ]);
        /*------------ end Of intromessages ----------*/

        /*------------ start Of introsocials ----------*/
        Route::get('introsocials', [
            'uses'  => 'IntroSocialController@index',
            'as'    => 'introsocials.index',
            'title' => 'socials',
            'icon'  => '<i class="la la-facebook"></i>',
        ]);

        # introsocials update
        Route::get('introsocials/{id}/Show', [
            'uses'  => 'IntroSocialController@show',
            'as'    => 'introsocials.show',
            'title' => 'view_socials',
        ]);
        # introsocials store
        Route::get('introsocials/create', [
            'uses'  => 'IntroSocialController@create',
            'as'    => 'introsocials.create',
            'title' => 'add_socials',
        ]);

        # introsocials store
        Route::post('introsocials/store', [
            'uses'  => 'IntroSocialController@store',
            'as'    => 'introsocials.store',
            'title' => 'add_socials',
        ]);
        # introsocials update
        Route::get('introsocials/{id}/edit', [
            'uses'  => 'IntroSocialController@edit',
            'as'    => 'introsocials.edit',
            'title' => 'edit_socials',
        ]);

        # introsocials update
        Route::put('introsocials/{id}', [
            'uses'  => 'IntroSocialController@update',
            'as'    => 'introsocials.update',
            'title' => 'edit_socials',
        ]);

        # introsocials delete
        Route::delete('introsocials/{id}', [
            'uses'  => 'IntroSocialController@destroy',
            'as'    => 'introsocials.delete',
            'title' => 'delete_socials',
        ]);

        #delete all introsocials
        Route::post('delete-all-introsocials', [
            'uses'  => 'IntroSocialController@destroyAll',
            'as'    => 'introsocials.deleteAll',
            'title' => 'delete_multible_socials',
        ]);
        /*------------ end Of introsocials ----------*/

        /*------------ start Of introhowworks ----------*/
        Route::get('introhowworks', [
            'uses'  => 'IntroHowWorkController@index',
            'as'    => 'introhowworks.index',
            'title' => 'how_the_site_works',
            'icon'  => '<i class="la la-calendar-check-o"></i>',
        ]);

        # introhowworks store
        Route::get('introhowworks/create', [
            'uses'  => 'IntroHowWorkController@create',
            'as'    => 'introhowworks.create',
            'title' => 'add_a_way_to_work',
        ]);
        # introfqscategories update
        Route::get('introhowworks/{id}/Show', [
            'uses'  => 'IntroHowWorkController@show',
            'as'    => 'introhowworks.show',
            'title' => 'view_a_way_to_work',
        ]);

        # introhowworks update
        Route::get('introhowworks/{id}/edit', [
            'uses'  => 'IntroHowWorkController@edit',
            'as'    => 'introhowworks.edit',
            'title' => 'edit_a_way_to_work',
        ]);

        # introhowworks store
        Route::post('introhowworks/store', [
            'uses'  => 'IntroHowWorkController@store',
            'as'    => 'introhowworks.store',
            'title' => ' اضافة خطوه',
        ]);

        # introhowworks update
        Route::put('introhowworks/{id}', [
            'uses'  => 'IntroHowWorkController@update',
            'as'    => 'introhowworks.update',
            'title' => 'تحديث خطوه',
        ]);

        # introhowworks delete
        Route::delete('introhowworks/{id}', [
            'uses'  => 'IntroHowWorkController@destroy',
            'as'    => 'introhowworks.delete',
            'title' => 'حذف خطوه',
        ]);

        #delete all introhowworks
        Route::post('delete-all-introhowworks', [
            'uses'  => 'IntroHowWorkController@destroyAll',
            'as'    => 'introhowworks.deleteAll',
            'title' => 'حذف مجموعه من كيف نعمل',
        ]);
        /*------------ end Of introhowworks ----------*/

        /*------------ end Of intro site ----------*/

        /*------------ start Of doctors ----------*/
        Route::get('doctors', [
            'uses'      => 'DoctorController@index',
            'as'        => 'doctors.index',
            'title'     => 'doctors',
            'icon'      => '<i class="fa fa-user-md"></i>',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'doctors.all', 'doctors.accepted', 'doctors.pending', 'doctors.create', 'doctors.store', 'clinicimage.delete',
                'doctors.edit', 'doctors.update', 'doctors.show', 'doctors.delete', 'doctors.deleteAll', 'doctor.request', 'ClinicBranch.delete',
                "doctors.branchs.all", "ClinicBranch.store", 'ClinicBranch.editBranch', "ClinicBranch.updateBranch", "ClinicBranch.show", "ClinicBranch.create", "",
            ],
        ]);

        #doctors all
        Route::get('doctors/all', [
            'uses'  => 'DoctorController@index',
            'as'    => 'doctors.all',
            'title' => 'doctors',
            'icon'  => '<i class="la la-user"></i>',

        ]);
        #doctors pending
        Route::get('doctors/pending', [
            'uses'  => 'DoctorController@index',
            'as'    => 'doctors.pending',
            'title' => 'doctors_pending',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        #doctor accepted
        Route::get('doctors/accept', [
            'uses'  => 'DoctorController@index',
            'as'    => 'doctors.accepted',
            'title' => 'doctors_accepted',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        #doctor_request
        Route::post('doctors/request-control/{id}', [
            'uses'  => 'DoctorController@acceptOrRefuse',
            'as'    => 'doctor.request',
            'title' => 'doctor_request',
        ]);

        # doctors store
        Route::get('doctors/create', [
            'uses'  => 'DoctorController@create',
            'as'    => 'doctors.create',
            'title' => 'add_doctor_page',
        ]);

        # doctors store
        Route::post('doctors/store', [
            'uses'  => 'DoctorController@store',
            'as'    => 'doctors.store',
            'title' => 'add_doctor',
        ]);

        # doctors update
        Route::get('doctors/{id}/edit', [
            'uses'  => 'DoctorController@edit',
            'as'    => 'doctors.edit',
            'title' => 'update_doctor_page',
        ]);

        # doctors update
        Route::put('doctors/{id}', [
            'uses'  => 'DoctorController@update',
            'as'    => 'doctors.update',
            'title' => 'update_doctor',
        ]);

        # doctors show
        Route::get('doctors/{id}/Show', [
            'uses'  => 'DoctorController@show',
            'as'    => 'doctors.show',
            'title' => 'show_doctor_page',
        ]);

        # doctors delete
        Route::delete('doctors/{id}', [
            'uses'  => 'DoctorController@destroy',
            'as'    => 'doctors.delete',
            'title' => 'delete_doctor',
        ]);
        #delete all doctors
        Route::post('delete-all-doctors', [
            'uses'  => 'DoctorController@destroyAll',
            'as'    => 'doctors.deleteAll',
            'title' => 'delete_group_of_doctors',
        ]);

        /*------------ end Of doctors ----------*/

        /*--------------------- clinics branches -----*/

        # clinics get
        Route::get('doctors/branchs/all/{id}', [
            'uses'  => 'DoctorController@clinicBranch',
            'as'    => 'doctors.branchs.all',
            'title' => 'doctors_branchs_page',
        ]);

        # ClinicBranch store
        Route::post('doctors/branches/store', [
            'uses'  => 'DoctorController@storeClinicBranch',
            'as'    => 'ClinicBranch.store',
            'title' => 'add_ClinicBranch',
        ]);

        # ClinicBranch edit
        Route::get('doctors/branches/{id}/edit', [
            'uses'  => 'DoctorController@editClinicBranch',
            'as'    => 'ClinicBranch.editBranch',
            'title' => 'update_add_ClinicBranch_page',
        ]);

        # ClinicBranch update
        Route::put('doctors/branches/{id}', [
            'uses'  => 'DoctorController@updateClinicBranch',
            'as'    => 'ClinicBranch.updateBranch',
            'title' => 'update_ClinicBranch',
        ]);
        # ClinicBranch show
        Route::get('doctors/branches/{id}/Show', [
            'uses'  => 'DoctorController@showClinicBranch',
            'as'    => 'ClinicBranch.show',
            'title' => 'show_update_ClinicBranch_page',
        ]);

        # ClinicBranch create
        Route::get('doctors/branches/create/{id?}', [
            'uses'  => 'DoctorController@createClinicBranch',
            'as'    => 'ClinicBranch.create',
            'title' => 'add_ClinicBranch_page',
        ]);

        # ClinicBranch delete
        Route::delete('doctors/branches/{id}', [
            'uses'  => 'DoctorController@destroyClinicBranch',
            'as'    => 'ClinicBranch.delete',
            'title' => 'delete_doctors_branch',
        ]);

        // delete image

        Route::delete('doctors/delete-image/{id}', [
            'uses'  => 'DoctorController@deleteImage',
            'as'    => 'clinicimage.delete',
            'title' => 'clinic_image_delete',
        ]);

        /*------------ end Of branches ----------*/

        /*------------ start Of pharmacies ----------*/
        Route::get('pharmacies', [
            'uses'      => 'PharmaciesController@index',
            'as'        => 'pharmacies.index',
            'title'     => 'pharmacies',
            'icon'      => '<i class="fa fa-medkit"></i>',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'pharmacies.all', 'pharmacies.request', 'pharmacies.accepted', 'pharmacies.pending', 'pharmacyBranch.show', 'pharmaciesimage.delete',
                'pharmacies.create', 'pharmacies.store', 'pharmacies.block', 'pharmacies.edit', 'pharmacies.update', 'pharmacyBranch.updateBranch',
                'pharmacies.show', 'pharmacies.delete', 'pharmacyBranch.store', 'pharmacyBranch.delete', 'pharmacies.deleteAll', 'pharmacies.branchs.all', 'pharmacyBranch.editBranch', 'pharmacyBranch.create',
            ],
        ]);

        #pharmacies all
        Route::get('pharmacies/all', [
            'uses'  => 'PharmaciesController@index',
            'as'    => 'pharmacies.all',
            'title' => 'pharmacies',
            'icon'  => '<i class="la la-user"></i>',

        ]);
        #pharmacies pending
        Route::get('pharmacies/pending', [
            'uses'  => 'PharmaciesController@index',
            'as'    => 'pharmacies.pending',
            'title' => 'pharmacies_pending',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        #pharmacies accepted
        Route::get('pharmacies/accept', [
            'uses'  => 'PharmaciesController@index',
            'as'    => 'pharmacies.accepted',
            'title' => 'pharmacies_accepted',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        #pharmacies request
        Route::post('pharmacies/request-control/{id}', [
            'uses'  => 'PharmaciesController@acceptOrRefuse',
            'as'    => 'pharmacies.request',
            'title' => 'pharmacies_request',
        ]);

        # pharmacies store
        Route::get('pharmacies/create', [
            'uses'  => 'PharmaciesController@create',
            'as'    => 'pharmacies.create',
            'title' => 'add_pharmacies_page',
        ]);

        #block
        Route::post('pharmacies/block', [
            'uses'  => 'PharmaciesController@block',
            'as'    => 'pharmacies.block',
            'title' => 'block_pharmacy',
        ]);

        # pharmacies store
        Route::post('pharmacies/store', [
            'uses'  => 'PharmaciesController@store',
            'as'    => 'pharmacies.store',
            'title' => 'add_pharmacies',
        ]);

        # pharmacies update
        Route::get('pharmacies/{id}/edit', [
            'uses'  => 'PharmaciesController@edit',
            'as'    => 'pharmacies.edit',
            'title' => 'update_pharmacies_page',
        ]);

        # pharmacies update
        Route::put('pharmacies/{id}', [
            'uses'  => 'PharmaciesController@update',
            'as'    => 'pharmacies.update',
            'title' => 'update_pharmacies',
        ]);

        # pharmacies show
        Route::get('pharmacies/{id}/Show', [
            'uses'  => 'PharmaciesController@show',
            'as'    => 'pharmacies.show',
            'title' => 'show_pharmacies_page',
        ]);

        # pharmacies delete
        Route::delete('pharmacies/{id}', [
            'uses'  => 'PharmaciesController@destroy',
            'as'    => 'pharmacies.delete',
            'title' => 'delete_pharmacies',
        ]);
        #delete all pharmacies
        Route::post('delete-all-pharmacies', [
            'uses'  => 'PharmaciesController@destroyAll',
            'as'    => 'pharmacies.deleteAll',
            'title' => 'delete_group_of_pharmacies',
        ]);

        //*******************branches****** */
        # pharmacies get
        Route::get('pharmacies/branchs/all/{id}', [
            'uses'  => 'PharmaciesController@PharamcyBranchs',
            'as'    => 'pharmacies.branchs.all',
            'title' => 'pharmacies_branchs_page',
        ]);

        # pharmacyBranch store
        Route::post('pharmacies/branches/store', [
            'uses'  => 'PharmaciesController@storeBranch',
            'as'    => 'pharmacyBranch.store',
            'title' => 'add_pharmacyBranch',
        ]);

        # pharmacyBranch edit
        Route::get('pharmacies/branches/{id}/edit', [
            'uses'  => 'PharmaciesController@editBranch',
            'as'    => 'pharmacyBranch.editBranch',
            'title' => 'update_pharmacyBranch_page',
        ]);

        # pharmacyBranch update
        Route::put('pharmacies/branches/{id}', [
            'uses'  => 'PharmaciesController@updateBranch',
            'as'    => 'pharmacyBranch.updateBranch',
            'title' => 'update_pharmacyBranch',
        ]);
        # pharmacyBranch show
        Route::get('pharmacies/branches/{id}/Show', [
            'uses'  => 'PharmaciesController@showBranch',
            'as'    => 'pharmacyBranch.show',
            'title' => 'show_pharmacyBranch_page',
        ]);

        # pharmacyBranch create
        Route::get('pharmacies/branches/create/{id?}', [
            'uses'  => 'PharmaciesController@createBranch',
            'as'    => 'pharmacyBranch.create',
            'title' => 'add_pharmacyBranch_page',
        ]);

        # pharmacyBranch delete
        Route::delete('pharmacies/branches/{id}', [
            'uses'  => 'PharmaciesController@destroyBranch',
            'as'    => 'pharmacyBranch.delete',
            'title' => 'delete_pharmacies_branch',
        ]);

        // delete image

        Route::delete('pharmacies/delete-image/{id}', [
            'uses'  => 'PharmaciesController@deleteImage',
            'as'    => 'pharmaciesimage.delete',
            'title' => 'pharmacies_image_delete',
        ]);

        /*------------ end Of pharmacies ----------*/

        /*------------ start Of labs ----------*/
        Route::get('labs', [
            'uses'      => 'LabController@index',
            'as'        => 'labs.index',
            'title'     => 'labs',
            'icon'      => '<i class="fa fa-flask"></i>',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'labs.all', 'labs.accepted', 'lab.request', 'labs.pending', 'labs.create', 'labs.store', 'labimage.delete',
                'labs.edit', 'labs.update', 'labs.show', 'labs.delete', 'labs.deleteAll', 'lab.branchs.all', 'lab.Branch.store', 'lab.sonar.category', 'lab.Branch.edit', 'lab.Branch.update', 'lab.Branch.show', 'lab.Branch.create', 'lab.Branch.delete',
            ],
        ]);

        #doctor_request
        Route::post('labs/request-control/{id}', [
            'uses'  => 'LabController@acceptOrRefuse',
            'as'    => 'lab.request',
            'title' => 'lab_request',
        ]);

        #labs all
        Route::get('labs/all', [
            'uses'  => 'LabController@index',
            'as'    => 'labs.all',
            'title' => 'labs',
            'icon'  => '<i class="la la-user"></i>',

        ]);
        #labs pending
        Route::get('labs/pending', [
            'uses'  => 'LabController@index',
            'as'    => 'labs.pending',
            'title' => 'labs_pending',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        #labs accepted
        Route::get('labs/accept', [
            'uses'  => 'LabController@index',
            'as'    => 'labs.accepted',
            'title' => 'labs_accepted',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        # labs store
        Route::get('labs/create', [
            'uses'  => 'LabController@create',
            'as'    => 'labs.create',
            'title' => 'add_lab_page',
        ]);

        # labs store
        Route::post('labs/store', [
            'uses'  => 'LabController@store',
            'as'    => 'labs.store',
            'title' => 'add_lab',
        ]);

        # labs update
        Route::get('labs/{id}/edit', [
            'uses'  => 'LabController@edit',
            'as'    => 'labs.edit',
            'title' => 'update_lab_page',
        ]);

        # labs update
        Route::put('labs/{id}', [
            'uses'  => 'LabController@update',
            'as'    => 'labs.update',
            'title' => 'update_lab',
        ]);

        # labs show
        Route::get('labs/{id}/Show', [
            'uses'  => 'LabController@show',
            'as'    => 'labs.show',
            'title' => 'show_lab_page',
        ]);

        # labs delete
        Route::delete('labs/{id}', [
            'uses'  => 'LabController@destroy',
            'as'    => 'labs.delete',
            'title' => 'delete_lab',
        ]);
        #delete all labs
        Route::post('delete-all-labs', [
            'uses'  => 'LabController@destroyAll',
            'as'    => 'labs.deleteAll',
            'title' => 'delete_group_of_labs',
        ]);

        /*--------------- start of lab branches-------*/
        # pharmacies get
        Route::get('lab/branchs/all/{id}', [
            'uses'  => 'LabController@labBranchs',
            'as'    => 'lab.branchs.all',
            'title' => 'lab_branchs_page',
        ]);

        # pharmacyBranch store
        Route::post('lab/branches/store', [
            'uses'  => 'LabController@storeBranch',
            'as'    => 'lab.Branch.store',
            'title' => 'add_lab_Branch',
        ]);

        # labBranch edit
        Route::get('lab/branches/{id}/edit', [
            'uses'  => 'LabController@editBranch',
            'as'    => 'lab.Branch.edit',
            'title' => 'update_labBranch_page',
        ]);

        # labBranch update
        Route::put('lab/branches/{id}', [
            'uses'  => 'LabController@updateBranch',
            'as'    => 'lab.Branch.update',
            'title' => 'update_labBranch',
        ]);
        # labBranch show
        Route::get('lab/branches/{id}/Show', [
            'uses'  => 'LabController@showBranch',
            'as'    => 'lab.Branch.show',
            'title' => 'show_labBranch_page',
        ]);

        # labBranch create
        Route::get('lab/branches/create/{id?}', [
            'uses'  => 'LabController@createBranch',
            'as'    => 'lab.Branch.create',
            'title' => 'add_labBranch_page',
        ]);

        # labBranch delete
        Route::delete('lab/branches/{id}', [
            'uses'  => 'LabController@destroyBranch',
            'as'    => 'lab.Branch.delete',
            'title' => 'delete_lab_branch',
        ]);

        // delete image

        Route::delete('lab/delete-image/{id}', [
            'uses'  => 'LabController@deleteImage',
            'as'    => 'labimage.delete',
            'title' => 'lab_image_delete',
        ]);

        // save sonar image

        Route::post('lab/sonar-category', [
            'uses'  => 'LabController@saveSonarCategory',
            'as'    => 'lab.sonar.category',
            'title' => 'save_sonar_category',
        ]);

        /*---------- end of branches------------*/
        /*------------ end Of labs ----------*/

        /*------------ start Of stores ----------*/
        Route::get('stores', [
            'uses'      => 'StoreController@index',
            'as'        => 'stores.index',
            'title'     => 'stores',
            'icon'      => '<i class="fa fa-shopping-basket"></i>',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'stores.all', 'stores.request', 'stores.accepted', 'stores.pending', 'stores.Branch.create', 'branch.image.delete',
                'stores.create', 'stores.store', 'stores.block', 'stores.edit', 'stores.update', 'stores.show', 'stores.Branch.show', 'stores.Branch.delete',
                'stores.delete', 'stores.deleteAll', 'stores.branchs.all', 'stores.Branch.store', 'stores.Branch.edit', 'stores.Branch.update',
            ],
        ]);

        #stores all
        Route::get('stores/all', [
            'uses'  => 'StoreController@index',
            'as'    => 'stores.all',
            'title' => 'stores',
            'icon'  => '<i class="la la-user"></i>',

        ]);
        #stores pending
        Route::get('stores/pending', [
            'uses'  => 'StoreController@index',
            'as'    => 'stores.pending',
            'title' => 'stores_pending',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        #stores accepted
        Route::get('stores/accept', [
            'uses'  => 'StoreController@index',
            'as'    => 'stores.accepted',
            'title' => 'stores_accepted',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        #store_request
        Route::post('stores/request-control/{id}', [
            'uses'  => 'StoreController@acceptOrRefuse',
            'as'    => 'stores.request',
            'title' => 'stores_request',
        ]);

        # stores store
        Route::get('stores/create', [
            'uses'  => 'StoreController@create',
            'as'    => 'stores.create',
            'title' => 'add_stores_page',
        ]);

        #block
        Route::post('stores/block', [
            'uses'  => 'StoreController@block',
            'as'    => 'stores.block',
            'title' => 'block_stores',
        ]);

        # stores store
        Route::post('stores/store', [
            'uses'  => 'StoreController@store',
            'as'    => 'stores.store',
            'title' => 'add_stores',
        ]);

        # stores update
        Route::get('stores/{id}/edit', [
            'uses'  => 'StoreController@edit',
            'as'    => 'stores.edit',
            'title' => 'update_stores_page',
        ]);

        # stores update
        Route::put('stores/{id}', [
            'uses'  => 'StoreController@update',
            'as'    => 'stores.update',
            'title' => 'update_stores',
        ]);

        # stores show
        Route::get('stores/{id}/Show', [
            'uses'  => 'StoreController@show',
            'as'    => 'stores.show',
            'title' => 'show_stores_page',
        ]);

        # stores delete
        Route::delete('stores/{id}', [
            'uses'  => 'StoreController@destroy',
            'as'    => 'stores.delete',
            'title' => 'delete_stores',
        ]);
        #delete all stores
        Route::post('delete-all-stores', [
            'uses'  => 'StoreController@destroyAll',
            'as'    => 'stores.deleteAll',
            'title' => 'delete_group_of_stores',
        ]);

        /*--------------- start of stores branches-------*/
        # stores get
        Route::get('stores/branchs/all/{id}', [
            'uses'  => 'StoreController@storesBranchs',
            'as'    => 'stores.branchs.all',
            'title' => 'stores_branchs_page',
        ]);

        # pharmacyBranch store
        Route::post('stores/branches/store', [
            'uses'  => 'StoreController@storeBranch',
            'as'    => 'stores.Branch.store',
            'title' => 'add_stores_Branch',
        ]);

        # storesBranch edit
        Route::get('stores/branches/{id}/edit', [
            'uses'  => 'StoreController@editBranch',
            'as'    => 'stores.Branch.edit',
            'title' => 'update_storesBranch_page',
        ]);

        # storesBranch update
        Route::put('stores/branches/{id}', [
            'uses'  => 'StoreController@updateBranch',
            'as'    => 'stores.Branch.update',
            'title' => 'update_storesBranch',
        ]);
        # storesBranch show
        Route::get('stores/branches/{id}/Show', [
            'uses'  => 'StoreController@showBranch',
            'as'    => 'stores.Branch.show',
            'title' => 'show_storesBranch_page',
        ]);

        # storesBranch create
        Route::get('stores/branches/create/{id?}', [
            'uses'  => 'StoreController@createBranch',
            'as'    => 'stores.Branch.create',
            'title' => 'add_storesBranch_page',
        ]);

        # storesBranch delete
        Route::delete('stores/branches/{id}', [
            'uses'  => 'StoreController@destroyBranch',
            'as'    => 'stores.Branch.delete',
            'title' => 'delete_stores_branch',
        ]);

        # images delete
        Route::delete('stores/delete-image/{id}', [
            'uses'  => 'StoreController@deleteImage',
            'as'    => 'branch.image.delete',
            'title' => 'store_image_delete',
        ]);

        /*---------- end stores  branches------------*/

        /*------------ end Of stores ----------*/

        /*------------ start Of reservations ----------*/
        Route::get('reservations', [
            'uses'      => 'ReservationController@index',
            'as'        => 'reservations.index',
            'title'     => 'reservations',
            'icon'      => '<i class="feather icon-credit-card"></i>',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => ['reservations.new', 'reservations.approved', 'reservations.on_progress', 'reservations.transferToLab', 'reservations.SendResults', 'reservations.finished', 'reservations.closed', 'reservations.show', 'reservations.create', 'reservations.store', 'reservations.edit', 'reservations.update', 'reservations.show', 'reservations.delete', 'reservations.deleteAll'],
        ]);

        # new reservations
        Route::get('reservations/new', [
            'uses'  => 'ReservationController@index',
            'as'    => 'reservations.new',
            'title' => 'reservation_new',
            'icon'  => '<i class="la la-user"></i>',
        ]);

        # transfer_to_lab reservations
        Route::get('reservations/lab_send_results', [
            'uses'  => 'ReservationController@index',
            'as'    => 'reservations.SendResults',
            'title' => 'reservation_SendResults',
            'icon'  => '<i class="la la-user"></i>',
        ]);

        # transfer_to_lab reservations
        Route::get('reservations/transfer_to_lab', [
            'uses'  => 'ReservationController@index',
            'as'    => 'reservations.transferToLab',
            'title' => 'reservation_transferToLab',
            'icon'  => '<i class="la la-user"></i>',
        ]);

        # approved reservations
        Route::get('reservations/approved', [
            'uses'  => 'ReservationController@index',
            'as'    => 'reservations.approved',
            'title' => 'reservation_approved',
            'icon'  => '<i class="la la-user"></i>',
        ]);
        # finished reservations
        Route::get('reservations/finished', [
            'uses'  => 'ReservationController@index',
            'as'    => 'reservations.finished',
            'title' => 'reservation_finished',
            'icon'  => '<i class="la la-user"></i>',
        ]);

        # on_progress reservations
        Route::get('reservations/on_progress', [
            'uses'  => 'ReservationController@index',
            'as'    => 'reservations.on_progress',
            'title' => 'reservation_on_progress',
            'icon'  => '<i class="la la-user"></i>',
        ]);
        # closed reservations
        Route::get('reservations/rejected', [
            'uses'  => 'ReservationController@index',
            'as'    => 'reservations.closed',
            'title' => 'reservation_rejected',
            'icon'  => '<i class="la la-user"></i>',
        ]);
        # reservations store
        Route::get('reservations/create', [
            'uses'  => 'ReservationController@create',
            'as'    => 'reservations.create',
            'title' => 'add_reservation_page',
        ]);

        # reservations store
        Route::post('reservations/store', [
            'uses'  => 'ReservationController@store',
            'as'    => 'reservations.store',
            'title' => 'add_reservation',
        ]);

        # reservations update
        Route::get('reservations/{id}/edit', [
            'uses'  => 'ReservationController@edit',
            'as'    => 'reservations.edit',
            'title' => 'update_reservation_page',
        ]);

        # reservations update
        Route::put('reservations/{id}', [
            'uses'  => 'ReservationController@update',
            'as'    => 'reservations.update',
            'title' => 'update_reservation',
        ]);

        # reservations show
        Route::get('reservations/{id}/Show', [
            'uses'  => 'ReservationController@show',
            'as'    => 'reservations.show',
            'title' => 'show_reservation_page',
        ]);

        # reservations delete
        Route::delete('reservations/{id}', [
            'uses'  => 'ReservationController@destroy',
            'as'    => 'reservations.delete',
            'title' => 'delete_reservation',
        ]);
        #delete all reservations
        Route::post('delete-all-reservations', [
            'uses'  => 'ReservationController@destroyAll',
            'as'    => 'reservations.deleteAll',
            'title' => 'delete_group_of_reservations',
        ]);
        /*------------ end Of reservations ----------*/

        /*------------ start Of orders ----------*/
        Route::get('orders', [
            'uses'      => 'OrderController@index',
            'as'        => 'orders.index',
            'title'     => 'orders',
            'icon'      => '<i class="feather icon-credit-card"></i>',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => ['orders.create', 'orders.all', 'orders.pending', 'orders.accepted', 'orders.prepared', 'orders.rejected', 'orders.store', 'orders.edit', 'orders.update', 'orders.show', 'orders.delete', 'orders.deleteAll'],
        ]);

        #orders all
        Route::get('orders/all', [
            'uses'  => 'OrderController@index',
            'as'    => 'orders.all',
            'title' => 'orders',
            'icon'  => '<i class="la la-user"></i>',

        ]);
        #orders pending
        Route::get('orders/pending', [
            'uses'  => 'OrderController@index',
            'as'    => 'orders.pending',
            'title' => 'orders_pending',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        #orders accepted
        Route::get('orders/accepted', [
            'uses'  => 'OrderController@index',
            'as'    => 'orders.accepted',
            'title' => 'orders_accepted',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        #orders accepted
        Route::get('orders/prepared', [
            'uses'  => 'OrderController@index',
            'as'    => 'orders.prepared',
            'title' => 'orders_prepared',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        #orders accepted
        Route::get('orders/rejected', [
            'uses'  => 'OrderController@index',
            'as'    => 'orders.rejected',
            'title' => 'orders_rejected',
            'icon'  => '<i class="la la-user"></i>',

        ]);

        # orders store
        Route::get('orders/create', [
            'uses'  => 'OrderController@create',
            'as'    => 'orders.create',
            'title' => 'add_order_page',
        ]);

        # orders store
        Route::post('orders/store', [
            'uses'  => 'OrderController@store',
            'as'    => 'orders.store',
            'title' => 'add_order',
        ]);

        # orders update
        Route::get('orders/{id}/edit', [
            'uses'  => 'OrderController@edit',
            'as'    => 'orders.edit',
            'title' => 'update_order_page',
        ]);

        # orders update
        Route::put('orders/{id}', [
            'uses'  => 'OrderController@update',
            'as'    => 'orders.update',
            'title' => 'update_order',
        ]);

        # orders show
        Route::get('orders/{id}/Show', [
            'uses'  => 'OrderController@show',
            'as'    => 'orders.show',
            'title' => 'show_order_page',
        ]);

        # orders delete
        Route::delete('orders/{id}', [
            'uses'  => 'OrderController@destroy',
            'as'    => 'orders.delete',
            'title' => 'delete_order',
        ]);
        #delete all orders
        Route::post('delete-all-orders', [
            'uses'  => 'OrderController@destroyAll',
            'as'    => 'orders.deleteAll',
            'title' => 'delete_group_of_orders',
        ]);
        /*------------ end Of orders ----------*/

        /*------------ public categories  ----------*/
        Route::get('public-categories', [
            'as'        => 'public-categories',
            'icon'      => '<i class="feather icon-list"></i>',
            'title'     => 'public_categories',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'notifications.index', 'notifications.send',
                'intros.index', 'intros.show', 'intros.create', 'intros.store', 'intros.edit', 'intros.update', 'intros.delete', 'intros.deleteAll',
                'images.index', 'images.show', 'images.create', 'images.store', 'images.edit', 'images.update', 'images.delete', 'images.deleteAll',
                'socials.index', 'socials.show', 'socials.create', 'socials.store', 'socials.show', 'socials.update', 'socials.edit', 'socials.delete', 'socials.deleteAll',
                'all_complaints', 'complaints.delete', 'complaints.deleteAll', 'complaints.show', 'complaint.replay',
                'fqs.index', 'fqs.show', 'fqs.create', 'fqs.store', 'fqs.edit', 'fqs.update', 'fqs.delete', 'fqs.deleteAll',
            ],
        ]);

        /*------------ start Of notifications ----------*/
        Route::get('notifications', [
            'uses'  => 'NotificationController@index',
            'as'    => 'notifications.index',
            'title' => 'notifications',
            'icon'  => '<i class="ficon feather icon-bell"></i>',
        ]);

        # coupons store
        Route::post('send-notifications', [
            'uses'  => 'NotificationController@sendNotifications',
            'as'    => 'notifications.send',
            'title' => 'send_notification_email_to_client',
        ]);
        /*------------ end Of notifications ----------*/

        /*------------ start Of intros ----------*/
        Route::get('intros', [
            'uses'  => 'IntroController@index',
            'as'    => 'intros.index',
            'title' => 'definition_pages',
            'icon'  => '<i class="feather icon-loader"></i>',
        ]);

        # intros update
        Route::get('intros/{id}/Show', [
            'uses'  => 'IntroController@show',
            'as'    => 'intros.show',
            'title' => 'view_a_profile_page',
        ]);

        # intros store
        Route::get('intros/create', [
            'uses'  => 'IntroController@create',
            'as'    => 'intros.create',
            'title' => 'add_a_profile_page',
        ]);

        # intros store
        Route::post('intros/store', [
            'uses'  => 'IntroController@store',
            'as'    => 'intros.store',
            'title' => 'add_a_profile_page',
        ]);

        # intros update
        Route::get('intros/{id}/edit', [
            'uses'  => 'IntroController@edit',
            'as'    => 'intros.edit',
            'title' => 'edit_a_profile_page',
        ]);

        # intros update
        Route::put('intros/{id}',
            [
                'uses'  => 'IntroController@update',
                'as'    => 'intros.update',
                'title' => 'edit_a_profile_page',
            ]
        );

        # intros delete
        Route::delete('intros/{id}', [
            'uses'  => 'IntroController@destroy',
            'as'    => 'intros.delete',
            'title' => 'delete_a_profile_page',
        ]);
        #delete all intros
        Route::post('delete-all-intros', [
            'uses'  => 'IntroController@destroyAll',
            'as'    => 'intros.deleteAll',
            'title' => 'delete_amultible__profile_page',
        ]);
        /*------------ end Of intros ----------*/

        /*------------ start Of images ----------*/
        Route::get('images', [
            'uses'  => 'ImageController@index',
            'as'    => 'images.index',
            'title' => 'advertising_banners',
            'icon'  => '<i class="feather icon-image"></i>',
        ]);
        Route::get('images/{id}/show', [
            'uses'  => 'ImageController@show',
            'as'    => 'images.show',
            'title' => 'view_of_banner',
        ]);
        # images store
        Route::get('images/create', [
            'uses'  => 'ImageController@create',
            'as'    => 'images.create',
            'title' => 'add_a_banner',
        ]);

        # images store
        Route::post('images/store', [
            'uses'  => 'ImageController@store',
            'as'    => 'images.store',
            'title' => 'add_a_banner',
        ]);

        # images update
        Route::get('images/{id}/edit', [
            'uses'  => 'ImageController@edit',
            'as'    => 'images.edit',
            'title' => 'modification_of_banner',
        ]);

        # images update
        Route::put('images/{id}',
            [
                'uses'  => 'ImageController@update',
                'as'    => 'images.update',
                'title' => 'modification_of_banner',
            ]
        );

        # images delete
        Route::delete('images/{id}', [
            'uses'  => 'ImageController@destroy',
            'as'    => 'images.delete',
            'title' => 'delete_a_banner',
        ]);
        #delete all images
        Route::post('delete-all-images', [
            'uses'  => 'ImageController@destroyAll',
            'as'    => 'images.deleteAll',
            'title' => 'delete_multible_banner',
        ]);
        /*------------ end Of images ----------*/

        /*------------ start Of socials ----------*/
        Route::get('socials', [
            'uses'  => 'SocialController@index',
            'as'    => 'socials.index',
            'title' => 'socials',
            'icon'  => '<i class="feather icon-message-circle"></i>',
        ]);
        # socials update
        Route::get('socials/{id}/Show', [
            'uses'  => 'SocialController@show',
            'as'    => 'socials.show',
            'title' => 'view_socials',
        ]);
        # socials store
        Route::get('socials/create', [
            'uses'  => 'SocialController@create',
            'as'    => 'socials.create',
            'title' => 'add_socials',
        ]);

        # socials store
        Route::post('socials',
            [
                'uses'  => 'SocialController@store',
                'as'    => 'socials.store',
                'title' => 'add_socials',
            ]
        );
        # socials update
        Route::get('socials/{id}/edit', [
            'uses'  => 'SocialController@edit',
            'as'    => 'socials.edit',
            'title' => 'edit_socials',
        ]);
        # socials update
        Route::put('socials/{id}', [
            'uses'  => 'SocialController@update',
            'as'    => 'socials.update',
            'title' => 'edit_socials',
        ]);

        # socials delete
        Route::delete('socials/{id}', [
            'uses'  => 'SocialController@destroy',
            'as'    => 'socials.delete',
            'title' => 'delete_socials',
        ]);

        #delete all socials
        Route::post('delete-all-socials', [
            'uses'  => 'SocialController@destroyAll',
            'as'    => 'socials.deleteAll',
            'title' => 'delete_multible_socials',
        ]);
        /*------------ end Of socials ----------*/

        /*------------ start Of complaints ----------*/
        Route::get('all-complaints', [
            'as'    => 'all_complaints',
            'uses'  => 'ComplaintController@index',
            'icon'  => '<i class="feather icon-mail"></i>',
            'title' => 'complaints_and_proposals',
        ]);

        # complaint replay
        Route::post('complaints-replay/{id}', [
            'uses'  => 'ComplaintController@replay',
            'as'    => 'complaint.replay',
            'title' => 'the_replay_of_complaining_or_proposal',
        ]);
        # socials update
        Route::get('complaints/{id}', [
            'uses'  => 'ComplaintController@show',
            'as'    => 'complaints.show',
            'title' => 'the_resolution_of_complaining_or_proposal',
        ]);

        # complaints delete
        Route::delete('complaints/{id}', [
            'uses'  => 'ComplaintController@destroy',
            'as'    => 'complaints.delete',
            'title' => 'delete_complaining',
        ]);

        #delete all complaints
        Route::post('delete-all-complaints', [
            'uses'  => 'ComplaintController@destroyAll',
            'as'    => 'complaints.deleteAll',
            'title' => 'delete_multibles_complaining',
        ]);
        /*------------ end Of complaints ----------*/

        /*------------ start Of fqs ----------*/
        Route::get('fqs', [
            'uses'  => 'FqsController@index',
            'as'    => 'fqs.index',
            'title' => 'questions_sections',
            'icon'  => '<i class="feather icon-alert-circle"></i>',
        ]);

        Route::get('fqs/{id}/show', [
            'uses'  => 'FqsController@show',
            'as'    => 'fqs.show',
            'title' => 'view_question',
        ]);

        # fqs store
        Route::get('fqs/create', [
            'uses'  => 'FqsController@create',
            'as'    => 'fqs.create',
            'title' => 'add_question',
        ]);

        # fqs store
        Route::post('fqs/store', [
            'uses'  => 'FqsController@store',
            'as'    => 'fqs.store',
            'title' => 'add_question',
        ]);

        # fqs update
        Route::get('fqs/{id}/edit',
            [
                'uses'  => 'FqsController@edit',
                'as'    => 'fqs.edit',
                'title' => 'edit_question',
            ]
        );

        # fqs update
        Route::put('fqs/{id}', [
            'uses'  => 'FqsController@update',
            'as'    => 'fqs.update',
            'title' => 'edit_question',
        ]);

        # fqs delete
        Route::delete('fqs/{id}',
            [
                'uses'  => 'FqsController@destroy',
                'as'    => 'fqs.delete',
                'title' => 'delete_question',
            ]
        );
        #delete all fqs
        Route::post('delete-all-fqs', [
            'uses'  => 'FqsController@destroyAll',
            'as'    => 'fqs.deleteAll',
            'title' => 'delete_multible_question ',
        ]);
        /*------------ end Of fqs ----------*/

        /*------------ public categories  ----------*/

        /*------------ public settings  ----------*/
        Route::get('public-settings', [
            'as'        => 'public-settings',
            'icon'      => '<i class="feather icon-settings"></i>',
            'title'     => 'public_settings',
            'type'      => 'parent',
            'sub_route' => true,
            'child'     => [
                'settings.index', 'settings.update', 'settings.message.all', 'settings.message.one', 'settings.send_email',
                'roles.index', 'roles.create', 'roles.store', 'roles.edit', 'roles.update', 'roles.delete',
                'sms.index', 'sms.update', 'sms.change', 'statistics.index',
                'reports', 'reports.delete', 'reports.deleteAll', 'reports.show',
            ],
        ]);

        /*------------ start Of sms ----------*/
        Route::get('sms', [
            'uses'  => 'SMSController@index',
            'as'    => 'sms.index',
            'title' => 'message_packages',
            'icon'  => '<i class="feather icon-smartphone"></i>',
        ]);
        # sms change
        Route::post('sms-change', [
            'uses'  => 'SMSController@change',
            'as'    => 'sms.change',
            'title' => 'message_update',
        ]);
        # sms update
        Route::put('sms/{id}', [
            'uses'  => 'SMSController@update',
            'as'    => 'sms.update',
            'title' => 'message_update',
        ]);

        /*------------ end Of sms ----------*/

        /*------------ start Of statistics ----------*/
        Route::get('statistics', [
            'uses'  => 'StatisticsController@index',
            'as'    => 'statistics.index',
            'title' => 'Statistics',
            'icon'  => '<i class="feather icon-activity"></i>',
        ]);
        /*------------ end Of statistics ----------*/

        /*------------ start Of reports----------*/
        Route::get('reports', [
            'uses'  => 'ReportController@index',
            'as'    => 'reports',
            'icon'  => '<i class="feather icon-edit-2"></i>',
            'title' => 'reports',
        ]);

        # reports show
        Route::get('reports/{id}',
            [
                'uses'  => 'ReportController@show',
                'as'    => 'reports.show',
                'title' => 'show_report',
            ]
        );
        # reports delete
        Route::delete('reports/{id}', [
            'uses'  => 'ReportController@destroy',
            'as'    => 'reports.delete',
            'title' => 'delete_report',
        ]);

        #delete all reports
        Route::post('delete-all-reports', [
            'uses'  => 'ReportController@destroyAll',
            'as'    => 'reports.deleteAll',
            'title' => 'delete_multible_report',
        ]);
        /*------------ end Of reports ----------*/

        /*------------ start Of Roles----------*/
        Route::get('roles', [
            'uses'  => 'RoleController@index',
            'as'    => 'roles.index',
            'title' => 'Validities_list',
            'icon'  => '<i class="feather icon-eye"></i>',
        ]);

        #add role page
        Route::get('roles/create',
            [
                'uses'  => 'RoleController@create',
                'as'    => 'roles.create',
                'title' => 'add_role',

            ]
        );

        #store role
        Route::post('roles/store',
            [
                'uses'  => 'RoleController@store',
                'as'    => 'roles.store',
                'title' => 'add_role',
            ]
        );

        #edit role page
        Route::get('roles/{id}/edit', [
            'uses'  => 'RoleController@edit',
            'as'    => 'roles.edit',
            'title' => 'edit_role',
        ]);

        #update role
        Route::put('roles/{id}', [
            'uses'  => 'RoleController@update',
            'as'    => 'roles.update',
            'title' => 'edit_role',
        ]);

        #delete role
        Route::delete('roles/{id}',
            [
                'uses'  => 'RoleController@destroy',
                'as'    => 'roles.delete',
                'title' => 'delete_role',
            ]
        );
        /*------------ end Of Roles----------*/

        /*------------ start Of Settings----------*/
        Route::get('settings', [
            'uses'  => 'SettingController@index',
            'as'    => 'settings.index',
            'title' => 'setting',
            'icon'  => '<i class="feather icon-settings"></i>',
        ]);

        #update
        Route::put('settings', [
            'uses'  => 'SettingController@update',
            'as'    => 'settings.update',
            'title' => 'edit_setting',
        ]);

        #message all
        Route::post('settings/{type}/message-all', [
            'uses'  => 'SettingController@messageAll',
            'as'    => 'settings.message.all',
            'title' => 'message_all',
        ])->where('type', 'email|sms|notification');

        #message one
        Route::post('settings/{type}/message-one', [
            'uses'  => 'SettingController@messageOne',
            'as'    => 'settings.message.one',
            'title' => 'message_one',
        ])->where('type', 'email|sms|notification');

        #send email
        Route::post('settings/send-email', [
            'uses'  => 'SettingController@sendEmail',
            'as'    => 'settings.send_email',
            'title' => 'send_email',
        ]);
        /*------------ end Of Settings ----------*/
        /*------------ public settings  ----------*/

        /*------------ start Of medicaladvices ----------*/
        Route::get('medicaladvices', [
            'uses'      => 'MedicalAdviceController@index',
            'as'        => 'medicaladvices.index',
            'title'     => 'medicaladvices',
            'icon'      => '<i class="fa fa-lightbulb-o"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['medicaladvices.create', 'medicaladvices.store', 'medicaladvices.edit', 'medicaladvices.update', 'medicaladvices.show', 'medicaladvices.deleteImage', 'medicaladvices.delete', 'medicaladvices.deleteAll'],
        ]);

        # medicaladvices store
        Route::get('medicaladvices/create', [
            'uses'  => 'MedicalAdviceController@create',
            'as'    => 'medicaladvices.create',
            'title' => 'add_medicaladvice_page',
        ]);

        # medicaladvices store
        Route::post('medicaladvices/store', [
            'uses'  => 'MedicalAdviceController@store',
            'as'    => 'medicaladvices.store',
            'title' => 'add_medicaladvice',
        ]);

        # medicaladvices update
        Route::get('medicaladvices/{id}/edit', [
            'uses'  => 'MedicalAdviceController@edit',
            'as'    => 'medicaladvices.edit',
            'title' => 'update_medicaladvice_page',
        ]);

        # medicaladvices update
        Route::put('medicaladvices/{id}', [
            'uses'  => 'MedicalAdviceController@update',
            'as'    => 'medicaladvices.update',
            'title' => 'update_medicaladvice',
        ]);

        # medicaladvices show
        Route::get('medicaladvices/{id}/Show', [
            'uses'  => 'MedicalAdviceController@show',
            'as'    => 'medicaladvices.show',
            'title' => 'show_medicaladvice_page',
        ]);

        # medicaladvices delete
        Route::post('medicaladvices/deleteImage', [
            'uses'  => 'MedicalAdviceController@deleteImage',
            'as'    => 'medicaladvices.deleteImage',
            'title' => 'delete_medicaladvice_image',
        ]);

        # medicaladvices delete
        Route::delete('medicaladvices/{id}', [
            'uses'  => 'MedicalAdviceController@destroy',
            'as'    => 'medicaladvices.delete',
            'title' => 'delete_medicaladvice',
        ]);
        #delete all medicaladvices
        Route::post('delete-all-medicaladvices', [
            'uses'  => 'MedicalAdviceController@destroyAll',
            'as'    => 'medicaladvices.deleteAll',
            'title' => 'delete_group_of_medicaladvices',
        ]);
        /*------------ end Of medicaladvices ----------*/

        /*------------ start Of sitemessages ----------*/
        Route::get('sitemessages', [
            'uses'      => 'SiteMessageController@index',
            'as'        => 'sitemessages.index',
            'title'     => 'sitemessages',
            'icon'      => '<i class="fa fa-comments"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['sitemessages.show', 'sitemessages.delete', 'sitemessages.deleteAll'],
        ]);

        # sitemessages show
        Route::get('sitemessages/{id}/Show', [
            'uses'  => 'SiteMessageController@show',
            'as'    => 'sitemessages.show',
            'title' => 'show_sitemessage_page',
        ]);

        # sitemessages delete
        Route::delete('sitemessages/{id}', [
            'uses'  => 'SiteMessageController@destroy',
            'as'    => 'sitemessages.delete',
            'title' => 'delete_sitemessage',
        ]);
        #delete all sitemessages
        Route::post('delete-all-sitemessages', [
            'uses'  => 'SiteMessageController@destroyAll',
            'as'    => 'sitemessages.deleteAll',
            'title' => 'delete_group_of_sitemessages',
        ]);
        /*------------ end Of sitemessages ----------*/

        /*------------ start Of sitefeatures ----------*/
        Route::get('sitefeatures', [
            'uses'      => 'SiteFeatureController@index',
            'as'        => 'sitefeatures.index',
            'title'     => 'sitefeatures',
            'icon'      => '<i class="feather icon-image"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['sitefeatures.create', 'sitefeatures.store', 'sitefeatures.edit', 'sitefeatures.update', 'sitefeatures.show', 'sitefeatures.delete', 'sitefeatures.deleteAll'],
        ]);

        # sitefeatures store
        Route::get('sitefeatures/create', [
            'uses'  => 'SiteFeatureController@create',
            'as'    => 'sitefeatures.create',
            'title' => 'add_sitefeature_page',
        ]);

        # sitefeatures store
        Route::post('sitefeatures/store', [
            'uses'  => 'SiteFeatureController@store',
            'as'    => 'sitefeatures.store',
            'title' => 'add_sitefeature',
        ]);

        # sitefeatures update
        Route::get('sitefeatures/{id}/edit', [
            'uses'  => 'SiteFeatureController@edit',
            'as'    => 'sitefeatures.edit',
            'title' => 'update_sitefeature_page',
        ]);

        # sitefeatures update
        Route::put('sitefeatures/{id}', [
            'uses'  => 'SiteFeatureController@update',
            'as'    => 'sitefeatures.update',
            'title' => 'update_sitefeature',
        ]);

        # sitefeatures show
        Route::get('sitefeatures/{id}/Show', [
            'uses'  => 'SiteFeatureController@show',
            'as'    => 'sitefeatures.show',
            'title' => 'show_sitefeature_page',
        ]);

        # sitefeatures delete
        Route::delete('sitefeatures/{id}', [
            'uses'  => 'SiteFeatureController@destroy',
            'as'    => 'sitefeatures.delete',
            'title' => 'delete_sitefeature',
        ]);
        #delete all sitefeatures
        Route::post('delete-all-sitefeatures', [
            'uses'  => 'SiteFeatureController@destroyAll',
            'as'    => 'sitefeatures.deleteAll',
            'title' => 'delete_group_of_sitefeatures',
        ]);
        /*------------ end Of sitefeatures ----------*/

        /*------------ start Of apppages ----------*/
        Route::get('apppages', [
            'uses'      => 'AppPageController@index',
            'as'        => 'apppages.index',
            'title'     => 'apppages',
            'icon'      => '<i class="feather icon-image"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['apppages.create', 'apppages.store', 'apppages.edit', 'apppages.update', 'apppages.show', 'apppages.delete', 'apppages.deleteAll'],
        ]);

        # apppages store
        Route::get('apppages/create', [
            'uses'  => 'AppPageController@create',
            'as'    => 'apppages.create',
            'title' => 'add_apppage_page',
        ]);

        # apppages store
        Route::post('apppages/store', [
            'uses'  => 'AppPageController@store',
            'as'    => 'apppages.store',
            'title' => 'add_apppage',
        ]);

        # apppages update
        Route::get('apppages/{id}/edit', [
            'uses'  => 'AppPageController@edit',
            'as'    => 'apppages.edit',
            'title' => 'update_apppage_page',
        ]);

        # apppages update
        Route::put('apppages/{id}', [
            'uses'  => 'AppPageController@update',
            'as'    => 'apppages.update',
            'title' => 'update_apppage',
        ]);

        # apppages show
        Route::get('apppages/{id}/Show', [
            'uses'  => 'AppPageController@show',
            'as'    => 'apppages.show',
            'title' => 'show_apppage_page',
        ]);

        # apppages delete
        Route::delete('apppages/{id}', [
            'uses'  => 'AppPageController@destroy',
            'as'    => 'apppages.delete',
            'title' => 'delete_apppage',
        ]);
        #delete all apppages
        Route::post('delete-all-apppages', [
            'uses'  => 'AppPageController@destroyAll',
            'as'    => 'apppages.deleteAll',
            'title' => 'delete_group_of_apppages',
        ]);
        /*------------ end Of apppages ----------*/

        /*------------ start Of cancelreasons ----------*/
        Route::get('cancelreasons', [
            'uses'      => 'CancelReasonController@index',
            'as'        => 'cancelreasons.index',
            'title'     => 'cancelreasons',
            'icon'      => '<i class="fa fa-question"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['cancelreasons.create', 'cancelreasons.store', 'cancelreasons.edit', 'cancelreasons.update', 'cancelreasons.show', 'cancelreasons.delete', 'cancelreasons.deleteAll'],
        ]);

        # cancelreasons store
        Route::get('cancelreasons/create', [
            'uses'  => 'CancelReasonController@create',
            'as'    => 'cancelreasons.create',
            'title' => 'add_cancelreason_page',
        ]);

        # cancelreasons store
        Route::post('cancelreasons/store', [
            'uses'  => 'CancelReasonController@store',
            'as'    => 'cancelreasons.store',
            'title' => 'add_cancelreason',
        ]);

        # cancelreasons update
        Route::get('cancelreasons/{id}/edit', [
            'uses'  => 'CancelReasonController@edit',
            'as'    => 'cancelreasons.edit',
            'title' => 'update_cancelreason_page',
        ]);

        # cancelreasons update
        Route::put('cancelreasons/{id}', [
            'uses'  => 'CancelReasonController@update',
            'as'    => 'cancelreasons.update',
            'title' => 'update_cancelreason',
        ]);

        # cancelreasons show
        Route::get('cancelreasons/{id}/Show', [
            'uses'  => 'CancelReasonController@show',
            'as'    => 'cancelreasons.show',
            'title' => 'show_cancelreason_page',
        ]);

        # cancelreasons delete
        Route::delete('cancelreasons/{id}', [
            'uses'  => 'CancelReasonController@destroy',
            'as'    => 'cancelreasons.delete',
            'title' => 'delete_cancelreason',
        ]);
        #delete all cancelreasons
        Route::post('delete-all-cancelreasons', [
            'uses'  => 'CancelReasonController@destroyAll',
            'as'    => 'cancelreasons.deleteAll',
            'title' => 'delete_group_of_cancelreasons',
        ]);
        /*------------ end Of cancelreasons ----------*/

        /*------------ start Of suggestions ----------*/
        Route::get('suggestions', [
            'uses'      => 'SuggestionController@index',
            'as'        => 'suggestions.index',
            'title'     => 'suggestions',
            'icon'      => '<i class="feather icon-image"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['suggestions.show', 'suggestions.delete', 'suggestions.deleteAll'],
        ]);

        # suggestions show
        Route::get('suggestions/{id}/Show', [
            'uses'  => 'SuggestionController@show',
            'as'    => 'suggestions.show',
            'title' => 'show_suggestion_page',
        ]);

        # suggestions delete
        Route::delete('suggestions/{id}', [
            'uses'  => 'SuggestionController@destroy',
            'as'    => 'suggestions.delete',
            'title' => 'delete_suggestion',
        ]);
        #delete all suggestions
        Route::post('delete-all-suggestions', [
            'uses'  => 'SuggestionController@destroyAll',
            'as'    => 'suggestions.deleteAll',
            'title' => 'delete_group_of_suggestions',
        ]);
        /*------------ end Of suggestions ----------*/

        /*------------ start Of regions ----------*/
        // Route::get('regions', [
        //     'uses'      => 'RegionController@index',
        //     'as'        => 'regions.index',
        //     'title'     => 'regions',
        //     'icon'      => '<i class="fa fa-map-marker"></i>',
        //     'type'      => 'parent',
        //     'sub_route' => false,
        //     'child'     => ['regions.create', 'regions.store', 'regions.edit', 'regions.update', 'regions.show', 'regions.delete', 'regions.deleteAll'],
        // ]);

        // # regions store
        // Route::get('regions/create', [
        //     'uses'  => 'RegionController@create',
        //     'as'    => 'regions.create',
        //     'title' => 'add_region_page',
        // ]);

        // # regions store
        // Route::post('regions/store', [
        //     'uses'  => 'RegionController@store',
        //     'as'    => 'regions.store',
        //     'title' => 'add_region',
        // ]);

        // # regions update
        // Route::get('regions/{id}/edit', [
        //     'uses'  => 'RegionController@edit',
        //     'as'    => 'regions.edit',
        //     'title' => 'update_region_page',
        // ]);

        // # regions update
        // Route::put('regions/{id}', [
        //     'uses'  => 'RegionController@update',
        //     'as'    => 'regions.update',
        //     'title' => 'update_region',
        // ]);

        // # regions show
        // Route::get('regions/{id}/Show', [
        //     'uses'  => 'RegionController@show',
        //     'as'    => 'regions.show',
        //     'title' => 'show_region_page',
        // ]);

        // # regions delete
        // Route::delete('regions/{id}', [
        //     'uses'  => 'RegionController@destroy',
        //     'as'    => 'regions.delete',
        //     'title' => 'delete_region',
        // ]);
        // #delete all regions
        // Route::post('delete-all-regions', [
        //     'uses'  => 'RegionController@destroyAll',
        //     'as'    => 'regions.deleteAll',
        //     'title' => 'delete_group_of_regions',
        // ]);
        /*------------ end Of regions ----------*/

        /*------------ start Of coupons ----------*/
        // Route::get('coupons', [
        //     'uses'      => 'CouponController@index',
        //     'as'        => 'coupons.index',
        //     'title'     => 'coupons',
        //     'icon'      => '<i class="fa fa-gift"></i>',
        //     'type'      => 'parent',
        //     'sub_route' => false,
        //     'child'     => ['coupons.show', 'coupons.create', 'coupons.store', 'coupons.edit', 'coupons.update', 'coupons.delete', 'coupons.deleteAll', 'coupons.renew'],
        // ]);

        // Route::get('coupons/{id}/show', [
        //     'uses'  => 'CouponController@show',
        //     'as'    => 'coupons.show',
        //     'title' => 'view_coupons',
        // ]);

        // # coupons store
        // Route::get('coupons/create', [
        //     'uses'  => 'CouponController@create',
        //     'as'    => 'coupons.create',
        //     'title' => 'add_coupons',
        // ]);

        // # coupons store
        // Route::post('coupons/store', [
        //     'uses'  => 'CouponController@store',
        //     'as'    => 'coupons.store',
        //     'title' => 'add_coupons',
        // ]);

        // # coupons update
        // Route::get('coupons/{id}/edit', [
        //     'uses'  => 'CouponController@edit',
        //     'as'    => 'coupons.edit',
        //     'title' => 'edit_coupons',
        // ]);

        // # coupons update
        // Route::put('coupons/{id}', [
        //     'uses'  => 'CouponController@update',
        //     'as'    => 'coupons.update',
        //     'title' => 'edit_coupons',
        // ]);

        // # renew coupon
        // Route::post('coupons/renew', [
        //     'uses'  => 'CouponController@renew',
        //     'as'    => 'coupons.renew',
        //     'title' => 'update_coupon_status',
        // ]);

        // # coupons delete
        // Route::delete('coupons/{id}', [
        //     'uses'  => 'CouponController@destroy',
        //     'as'    => 'coupons.delete',
        //     'title' => 'delete_coupons',
        // ]);
        // #delete all coupons
        // Route::post('delete-all-coupons', [
        //     'uses'  => 'CouponController@destroyAll',
        //     'as'    => 'coupons.deleteAll',
        //     'title' => 'delete_multible_coupons',
        // ]);
        /*------------ end Of coupons ----------*/

        /*------------ start Of seos ----------*/
        // Route::get('seos', [
        //     'uses'  => 'SeoController@index',
        //     'as'    => 'seos.index',
        //     'title' => 'seo',
        //     'icon'  => '<i class="feather icon-list"></i>',
        //     'type'  => 'parent',
        //     'child' => [
        //         'seos.show', 'seos.create', 'seos.edit', 'seos.index', 'seos.store', 'seos.update', 'seos.delete', 'seos.deleteAll',
        //     ],
        // ]);
        # seos update
        // Route::get('seos/{id}/Show', [
        //     'uses'  => 'SeoController@show',
        //     'as'    => 'seos.show',
        //     'title' => 'view_seo',
        // ]);

        // # seos store
        // Route::get('seos/create', [
        //     'uses'  => 'SeoController@create',
        //     'as'    => 'seos.create',
        //     'title' => 'add_seo',
        // ]);

        // # seos update
        // Route::get('seos/{id}/edit', [
        //     'uses'  => 'SeoController@edit',
        //     'as'    => 'seos.edit',
        //     'title' => 'edit_seo',
        // ]);

        // #store
        // Route::post('seos/store', [
        //     'uses'  => 'SeoController@store',
        //     'as'    => 'seos.store',
        //     'title' => 'add_seo',
        // ]);

        // #update
        // Route::put('seos/{id}', [
        //     'uses'  => 'SeoController@update',
        //     'as'    => 'seos.update',
        //     'title' => 'edit_seo',
        // ]);

        // #deletّe
        // Route::delete('seos/{id}', [
        //     'uses'  => 'SeoController@destroy',
        //     'as'    => 'seos.delete',
        //     'title' => 'delete_seo',
        // ]);
        // #delete
        // Route::post('delete-all-seos', [
        //     'uses'  => 'SeoController@destroyAll',
        //     'as'    => 'seos.deleteAll',
        //     'title' => 'delete_multible_seo',
        // ]);
        /*------------ end Of seos ----------*/

        /*------------ start Of reportrates ----------*/
        Route::get('reportrates', [
            'uses'      => 'ReportRateController@index',
            'as'        => 'reportrates.index',
            'title'     => 'reportrates',
            'icon'      => '<i class="feather icon-flag"></i>',
            'type'      => 'parent',
            'sub_route' => false,
            'child'     => ['reportrates.show', 'reportrates.delete', 'reportrates.deleteAll'],
        ]);

        # reportrates show
        Route::get('reportrates/{id}/Show', [
            'uses'  => 'ReportRateController@show',
            'as'    => 'reportrates.show',
            'title' => 'show_reportrate_page',
        ]);

        # reportrates delete
        Route::delete('reportrates/{id}', [
            'uses'  => 'ReportRateController@destroy',
            'as'    => 'reportrates.delete',
            'title' => 'delete_reportrate',
        ]);
        #delete all reportrates
        Route::post('delete-all-reportrates', [
            'uses'  => 'ReportRateController@destroyAll',
            'as'    => 'reportrates.deleteAll',
            'title' => 'delete_group_of_reportrates',
        ]);
        /*------------ end Of reportrates ----------*/
        #new_routes_here

    });
});
