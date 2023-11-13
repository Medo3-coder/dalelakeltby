<?php

	use App\Models\SiteSetting;
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Support\Facades\Cache;
	use App\Services\SettingService;

	class CreateSiteSettingsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema ::create( 'site_settings', function ( Blueprint $table ) {
				$table -> increments( 'id' );
				$table -> string( 'key', 50 );
				$table -> longText( 'value' );
				$table -> timestamps();
			} );
			Cache::forget('settings');
        $data = [
                [ 'key' => 'is_production'                  , 'value' => 0               ],
                [ 'key' => 'name_ar'                        , 'value' => 'اوامر الشبكه'               ],
                [ 'key' => 'name_en'                        , 'value' => 'Awamer Elshabka'              ],
                [ 'key' => 'email'                          , 'value' => 'aait@gmail.com'      ],
                [ 'key' => 'phone'                          , 'value' => '+966555184424'        ],
                [ 'key' => 'whatsapp'                       , 'value' => '+966555184424'        ],
                [ 'key' => 'terms_ar'                       , 'value' => 'الشروط والاحكام'      ],
                [ 'key' => 'terms_en'                       , 'value' => 'terms'                ],
                [ 'key' => 'terms_kur'                       , 'value' => 'مەرجەکان'                ],
                [ 'key' => 'about_ar'                       , 'value' => 'من نحن'               ],
                [ 'key' => 'about_en'                       , 'value' => 'about'                ],
                [ 'key' => 'about_kur'                       , 'value' => 'دەربارەی'                ],
                [ 'key' => 'privacy_ar'                     , 'value' => 'سياسة الخصوصية باللغه العربية'                ],
                [ 'key' => 'privacy_en'                     , 'value' => 'Privacy in english'                ],
                [ 'key' => 'logo'                           , 'value' => 'logo.png'             ],
                [ 'key' => 'fav_icon'                       , 'value' => 'fav_icon.png'             ],
                [ 'key' => 'login_background'               , 'value' => 'login_background.png'             ],
                [ 'key' => 'no_data_icon'                   , 'value' => 'fav.png'             ],
                [ 'key' => 'default_user'                   , 'value' => 'default.png'          ],
                [ 'key' => 'intro_email'                    , 'value' => 'email@gmail.com'      ],
                [ 'key' => 'intro_phone'                    , 'value' => '+966555184424'        ],
                [ 'key' => 'intro_address'                  , 'value' => 'الرياض - السعودية'        ],
                [ 'key' => 'intro_logo'                     , 'value' => 'intro_logo.png'       ],
                [ 'key' => 'intro_loader'                   , 'value' => 'intro_loader.png'       ],
                [ 'key' => 'about_image_2'                  , 'value' => 'about_image_2.png'       ],
                [ 'key' => 'about_image_1'                  , 'value' => 'about_image_1.png'       ],
                [ 'key' => 'intro_name_ar'                  , 'value' => 'اوامر الشبكة'    ],
                [ 'key' => 'intro_name_en'                  , 'value' => 'Awamer elshabka'    ],
                [ 'key' => 'intro_meta_description'         , 'value' => 'موقع تعريفي خاص ب اوامر الشبكة'    ],
                [ 'key' => 'intro_meta_keywords'            , 'value' => 'موقع تعريفي خاص ب اوامر الشبكة'    ],
                [ 'key' => 'intro_about_ar'                 , 'value' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساح'    ],
                [ 'key' => 'intro_about_en'                 , 'value' => 'This text is an example of text that can be replaced in the same space. This text was generated from the Arabic text generator, where you can generate such text or many other texts. This text is an example of text that can be replaced in the same space. This text is an example of text It can be replaced in the same space. This text was generated from the Arabic text generator, where you can generate such text or many other texts. This text is an example of a text that can be replaced in the same space.'    ],
                [ 'key' => 'services_text_ar'               , 'value' => 'من خلال بناء منتج بديهي يحاكي ويسهل تنفيذ الخدمة العامة ، كان الجواب البسيط هو تزويد المستخدمين بثلاثة أشياء'],
                [ 'key' => 'services_text_en'               , 'value' => 'By building an intuitive product that simulates and facilitates the implementation of public service, the simple answer has been to provide users with three things'    ],
                [ 'key' => 'how_work_text_ar'               , 'value' => 'من خلال بناء منتج بديهي يحاكي ويسهل تنفيذ الخدمة العامة ، كان الجواب البسيط هو تزويد المستخدمين بثلاثة أشياء'],
                [ 'key' => 'how_work_text_en'               , 'value' => 'By building an intuitive product that simulates and facilitates the implementation of public service, the simple answer has been to provide users with three things'    ],
                [ 'key' => 'fqs_text_ar'                    , 'value' => 'من خلال بناء منتج بديهي يحاكي ويسهل تنفيذ الخدمة العامة ، كان الجواب البسيط هو تزويد المستخدمين بثلاثة أشياء'],
                [ 'key' => 'fqs_text_en'                    , 'value' => 'By building an intuitive product that simulates and facilitates the implementation of public service, the simple answer has been to provide users with three things'    ],
                [ 'key' => 'parteners_text_ar'              , 'value' => 'من خلال بناء منتج بديهي يحاكي ويسهل تنفيذ الخدمة العامة ، كان الجواب البسيط هو تزويد المستخدمين بثلاثة أشياء'],
                [ 'key' => 'parteners_text_en'              , 'value' => 'By building an intuitive product that simulates and facilitates the implementation of public service, the simple answer has been to provide users with three things'    ],
                [ 'key' => 'contact_text_ar'                , 'value' => 'من خلال بناء منتج بديهي يحاكي ويسهل تنفيذ الخدمة العامة ، كان الجواب البسيط هو تزويد المستخدمين بثلاثة أشياء'],
                [ 'key' => 'contact_text_en'                , 'value' => 'By building an intuitive product that simulates and facilitates the implementation of public service, the simple answer has been to provide users with three things'    ],
                [ 'key' => 'color'                          , 'value' => '#10163a'    ],
                [ 'key' => 'buttons_color'                  , 'value' => '#7367F0'    ],
                [ 'key' => 'hover_color'                    , 'value' => '#262c49'    ],
                [ 'key' => 'how_work_ar'                    , 'value' => 'كيفية عمل التطبيق'    ],
                [ 'key' => 'how_work_en'                    , 'value' => 'how app work'    ],
                [ 'key' => 'how_work_kur'                   , 'value' => 'چۆن ئەپەکە کاردەکات'    ],
                
                [ 'key' => 'lab_header_title_ar'            , 'value' => 'انضم الينا الآن ... تعامل مع افضل الاطباء بالعراق'    ],
                [ 'key' => 'lab_header_title_en'            , 'value' => 'Join us now... deal with the best doctors in Iraq'    ],
                [ 'key' => 'lab_header_title_kur'           , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],
                [ 'key' => 'lab_header_description_ar'      , 'value' => 'انضم الينا الآن ... تعامل مع افضل الاطباء بالعراق'    ],
                [ 'key' => 'lab_header_description_en'      , 'value' => 'Join us now... deal with the best doctors in Iraq'    ],
                [ 'key' => 'lab_header_description_kur'     , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],
                
                [ 'key' => 'doctor_header_title_ar'         , 'value' => 'سجل وتابع مرضاك وحجوزاتك معنا بكل سهوله'    ],
                [ 'key' => 'doctor_header_title_en'         , 'value' => 'Join us now... deal with the best doctors in Iraq'    ],
                [ 'key' => 'doctor_header_title_kur'        , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],
                [ 'key' => 'doctor_header_description_ar'   , 'value' => 'سجل وتابع مرضاك وحجوزاتك معنا بكل سهوله'    ],
                [ 'key' => 'doctor_header_description_en'   , 'value' => 'Join us now... deal with the best doctors in Iraq'    ],
                [ 'key' => 'doctor_header_description_kur'  , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],
                
                [ 'key' => 'store_header_title_ar'          , 'value' => 'يمكنك تحقيق اعلي المبيعات للأدوية من خلال دليلك الطبي'    ],
                [ 'key' => 'store_header_title_en'          , 'value' => 'Join us now... deal with the best stores in Iraq'    ],
                [ 'key' => 'store_header_title_kur'         , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],
                [ 'key' => 'store_header_description_ar'    , 'value' => 'يمكنك تحقيق اعلي المبيعات للأدوية من خلال دليلك الطبي'    ],
                [ 'key' => 'store_header_description_en'    , 'value' => 'Join us now... deal with the best stores in Iraq'    ],
                [ 'key' => 'store_header_description_kur'   , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],                
                
                [ 'key' => 'pharmacy_header_title_ar'         , 'value' => 'تسوق الان ... اطلب دوائك واختر انسب وافصل المذاخر في العراق'    ],
                [ 'key' => 'pharmacy_header_title_en'         , 'value' => 'Join us now... deal with the best pharmacies in Iraq'    ],
                [ 'key' => 'pharmacy_header_title_kur'        , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],
                [ 'key' => 'pharmacy_header_description_ar'   , 'value' => 'تسوق الان ... اطلب دوائك واختر انسب وافصل المذاخر في العراق'    ],
                [ 'key' => 'pharmacy_header_description_en'   , 'value' => 'Join us now... deal with the best pharmacies in Iraq'    ],
                [ 'key' => 'pharmacy_header_description_kur'  , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],

                [ 'key' => 'most_famous_doctors_text_ar'   , 'value' => 'تسوق الان ... اطلب دوائك واختر انسب وافصل المذاخر في العراق'    ],
                [ 'key' => 'most_famous_doctors_text_en'   , 'value' => 'Join us now... deal with the best pharmacies in Iraq'    ],
                [ 'key' => 'most_famous_doctors_text_kur'  , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],

                [ 'key' => 'join_doctor_text_ar'            , 'value' => 'تسوق الان ... اطلب دوائك واختر انسب وافصل المذاخر في العراق'    ],
                [ 'key' => 'join_doctor_text_en'            , 'value' => 'Join us now... deal with the best pharmacies in Iraq'    ],
                [ 'key' => 'join_doctor_text_kur'           , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],

                [ 'key' => 'join_pharmacy_text_ar'            , 'value' => 'تسوق الان ... اطلب دوائك واختر انسب وافصل المذاخر في العراق'    ],
                [ 'key' => 'join_pharmacy_text_en'            , 'value' => 'Join us now... deal with the best pharmacies in Iraq'    ],
                [ 'key' => 'join_pharmacy_text_kur'           , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],

                [ 'key' => 'join_lab_text_ar'               , 'value' => 'تسوق الان ... اطلب دوائك واختر انسب وافصل المذاخر في العراق'    ],
                [ 'key' => 'join_lab_text_en'               , 'value' => 'Join us now... deal with the best pharmacies in Iraq'    ],
                [ 'key' => 'join_lab_text_kur'              , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],    

                [ 'key' => 'join_store_text_ar'            , 'value' => 'تسوق الان ... اطلب دوائك واختر انسب وافصل المذاخر في العراق'    ],
                [ 'key' => 'join_store_text_en'            , 'value' => 'Join us now... deal with the best pharmacies in Iraq'    ],
                [ 'key' => 'join_store_text_kur'           , 'value' => 'ئێستا لەگەڵمان بن... مامەڵە لەگەڵ باشترین پزیشکەکانی عێراق بکەن'    ],    

                [ 'key' => 'reservations_number_per_day'           , 'value' => '5'    ],    

                [ 'key' => 'google_play_link'               , 'value' => 'https://www.google.com'    ],
                [ 'key' => 'app_store_link'                 , 'value' => 'https://www.google.com'    ],
                [ 'key' => 'platform_explain_link'          , 'value' => 'https://www.google.com'    ],
                    
                // [ 'key' => 'downloads_count'                , 'value' => '100'    ],
                        
                [ 'key' => 'smtp_user_name'                 , 'value' => 'smtp_user_name'    ],
                [ 'key' => 'smtp_password'                  , 'value' => 'smtp_password'    ],
                [ 'key' => 'smtp_mail_from'                 , 'value' => 'smtp_mail_from'    ],
                [ 'key' => 'smtp_sender_name'               , 'value' => 'smtp_sender_name'    ],
                [ 'key' => 'smtp_port'                      , 'value' => '80'    ],
                [ 'key' => 'smtp_host'                      , 'value' => 'send.smtp.com'    ],
                [ 'key' => 'smtp_encryption'                , 'value' => 'LTS'    ],

                [ 'key' => 'firebase_key'                   , 'value' => 'AAAAxZZ2NiU:APA91bF3HfsEnp6ID-0BrJkoEfu0I8EunEJJYg_VX3hgZsbgpuFvrcY7XJ9qCVFfrRrUoWSQbknnsoXVOVNVH4KyGxV8hkIlGEdsA8NVFDpp7yjiC9WHKILArV1nBqwmJek9LPihRTZd'    ],
                [ 'key' => 'firebase_sender_id'             , 'value' => '848632886821'    ],

                [ 'key' => 'google_places'                  , 'value' => 'AIzaSyAXV7nrpIKpuqyaNWNQYr3IP86_rJgcHWc'    ],
                [ 'key' => 'google_analytics'               , 'value' => 'google_analytics'    ],
                [ 'key' => 'live_chat'                      , 'value' => '<iframe src="https://chat.socialintents.com/c/yoururl" width="480" height="540" frameborder="0"></iframe>'    ],

                [ 'key' => 'reservation_price'              , 'value' => 20],
                [ 'key' => 'admin_commission_ratio'         , 'value' => 10],
                [ 'key' => 'vat_rate_ratio'                 , 'value' => 10],
                [ 'key' => 'default_image'                  , 'value' => 'default.png'],


                [ 'key' => 'store_delivery_price'           , 'value' => '50'],
                [ 'key' => 'vat_ratio'                      , 'value' => '10'],

            ];
			SiteSetting ::insert( $data );
            
            Cache::rememberForever('settings', function () {
                return SettingService::appInformations(SiteSetting::pluck('value', 'key'));
            }); 
		}


		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
			Schema ::dropIfExists( 'site_settings' );
		}
	}
