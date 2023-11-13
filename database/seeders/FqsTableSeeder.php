<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class FqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fqs')->insert(
            [
                'question'       => json_encode(['ar' => 'تقديم تجربة ذات طابع شخصي لك:', 'en' => 'Providing you with a personalized experience:' , 'kur' => 'دابینکردنی ئەزموونێکی تایبەتمەند بۆ ئێوە:' ], JSON_UNESCAPED_UNICODE) ,
                'answer'         => json_encode([
                    'ar' => 'تختلف تجربتك على فيسبوك عن تجربة أي شخص آخر: بدءًا من المنشورات والقصص والمناسبات والإعلانات وغيرها من أنواع المحتوى الأخرى التي تظهر لك في آخر الأخبار أو منصة الفيديو التي نوفرها، إلى الصفحات التي تتابعها والميزات الأخرى التي قد تستخدمها، مثل الموضوعات الرائجة وMarketplace والبحث. ونستخدم البيانات المتوفرة لدينا، مثل تلك المتعلقة بعمليات التواصل التي تقوم بها والاختيارات والإعدادات التي تحددها والعناصر التي تقوم بمشاركتها والإجراءات التي تتخذها داخل منتجاتنا وخارجها، لإضفاء طابع شخصي على تجربتك.' ,
                    'en' => 'Your experience on Facebook is different from everyone elses: from the posts, stories, events, ads, and other types of content you see in your News Feed or our video platform, to the Pages you follow and other features you might use, like Trends, Marketplace, and search. We use the data we have, such as about your communications, choices and settings you make, what you share, and actions you take on and off our Products, to personalize your experience.' ,
                    'kur' => 'ئەزموونی تۆ لە فەیسبووک جیاوازە لە هەموو کەسێک: لە پۆست، چیرۆک، ڕووداو، ڕیکلام و جۆرەکانی تری ناوەڕۆکەوە کە لە نیوز فیدەکەت یان پلاتفۆرمی ڤیدیۆییەکەماندا دەیبینیت، تا ئەو پەیجانەی کە فۆڵۆویان دەکەیت و تایبەتمەندیەکانی تر لەوانەیە بەکاری بهێنیت، وەک Trends، Marketplace و گەڕان. ئێمە ئەو زانیاریانەی کە هەمانە بەکاردەهێنین، وەک دەربارەی پەیوەندییەکانتان، هەڵبژاردن و ڕێکخستنەکانت کە ئەنجامی دەدەیت، ئەوەی هاوبەشی دەکەیت، و ئەو کردارانەی کە ئەنجامی دەدەیت لەسەر بەرهەمەکانمان و لە بەرهەمەکانمان، بۆ ئەوەی ئەزموونەکەت کەسایەتی بکەین' 
                ], JSON_UNESCAPED_UNICODE) ,
            ] , [
                'question'       => json_encode(['ar' => 'توفير إمكانية التواصل مع الأشخاص والمؤسسات التي تهتم بها', 'en' => 'Providing the ability to communicate with the people and organizations you are interested in' , 'kur' => 'دابینکردنی توانای پەیوەندیکردن لەگەڵ ئەو کەس و ڕێکخراوانەی کە ئارەزووی دەکەیت' ], JSON_UNESCAPED_UNICODE) ,
                'answer'         => json_encode([
                    'ar' => 'نساعدك في العثور على الأشخاص والمجموعات والأنشطة التجارية والمؤسسات وغيرها مما يقع ضمن دائرة اهتماماتك والتواصل معها عبر منتجات فيسبوك التي تستخدمها. ونستخدم البيانات التي نحصل عليها لتقديم اقتراحات لك وللآخرين، على سبيل المثال، مجموعات للانضمام إليها، ومناسبات لحضورها، وصفحات لمتابعتها أو مراسلتها، وعروض لمشاهدتها، وأشخاص قد ترغب في أن تصبح صديقًا لهم. وتُعد الروابط القوية أساسًا مهمًا لبناء مجتمعات أفضل، ونحن على يقين أن خدماتنا تصبح أكثر فائدة عندما يتواصل الأشخاص معًا ومع المجموعات والمؤسسات التي يهتمون بها.' 
                ,   'en' =>  'We help you find and connect with people, groups, businesses, organizations and more that interest you through the Facebook products you use. We use the data we obtain to make suggestions to you and others, for example, groups to join, events to attend, pages to follow or message with, offers to watch, and people you might want to become friends with. Strong connections are an important foundation for building better communities, and we know that our services become even more useful when people connect with each other and with the groups and organizations they care about.' 
                ,   'kur' =>  'دابینکردنی ئێمە یارمەتیت دەدەین لە دۆزینەوە و پەیوەندی لەگەڵ کەسانێک، گروپەکان، بزنسەکان، ڕێکخراوەکان و زۆر شتی تر کە سەرنجڕاکێشت دەکەن لە ڕێگەی ئەو بەرهەمانەی فەیسبووکەوە کە بەکاریان دەهێنیت. ئێمە ئەو زانیاریانە بەکاردەهێنین کە بەدەستمان دەهێنین بۆ پێشنیارکردن بۆ تۆ و کەسانی دیکە، بۆ نموونە، گروپەکان بۆ بەشداریکردن، بۆنەکان بۆ بەشداریکردن، لاپەڕەکان بۆ شوێنکەوتن یان نامە لەگەڵیان، ئۆفەرەکان بۆ سەیرکردن، و ئەو کەسانەی کە ڕەنگە بتەوێت هاوڕێیان بیت. پەیوەندی بەهێز بنەمایەکی گرنگە بۆ بنیاتنانی کۆمەڵگەی باشتر، و دەزانین کە خزمەتگوزارییەکانمان کاتێکی زیاتر بەسوود دەبن کە مرۆڤەکان پەیوەندی لەگەڵ یەکتر و لەگەڵ ئەو گروپ و ڕێکخراوانەی کە گرنگی پێدەدەن توانای پەیوەندیکردن لەگەڵ ئەو کەس و ڕێکخراوانەی کە تۆ ئارەزووی دەکەیت.' 
            ], JSON_UNESCAPED_UNICODE) ,
        ],[
                'question'       => json_encode(['ar' => 'تشجيعك على التعبير عن نفسك والتواصل بشأن ما يهمّك:', 'en' => 'Encouraging you to express yourself and communicate what matters to you:' , 'kur' => 'هاندانی تۆ بۆ دەربڕینی خۆت و گەیاندنی ئەوەی کە بۆت گرنگە:' ], JSON_UNESCAPED_UNICODE) ,
                'answer'         => json_encode([
                    'ar' => 'نوفر لك العديد من الطرق للتعبير عن نفسك على فيسبوك والتواصل مع الأصدقاء وأفراد العائلة والأشخاص الآخرين بخصوص الأمور التي تهتم بها، على سبيل المثال، مشاركة تحديثات الحالة والصور ومقاطع الفيديو والقصص عبر منتجات فيسبوك التي تستخدمها، أو إرسال الرسائل إلى صديق أو عدة أشخاص، أو إنشاء مناسبات أو مجموعات، أو إضافة محتوى إلى ملفك الشخصي. ولقد قمنا أيضًا بتطوير، ولا نزال نكتشف، وسائل جديدة تتيح للأشخاص إمكانية استخدام التكنولوجيا، مثل الواقع المعزَّز والفيديو بتقنية 360 درجة لإنشاء المزيد من عناصر المحتوى الجاذبة للانتباه والتي تشجع على التفاعل ومشاركتها على فيسبوك',
                    'en' => 'We offer many ways for you to express yourself on Facebook and communicate with friends, family, and other people about things you care about, for example, sharing status updates, photos, videos, and stories across the Facebook Products you use, sending messages to a friend or multiple people, or Create events or groups, or add content to your profile. We have also developed, and continue to discover, new ways for people to use technology, such as augmented reality and 360-degree video to create more engaging, engaging content on Facebook.' ,
                    'kur' => 'ئێمە چەندین ڕێگە پێشکەش دەکەین بۆ ئەوەی خۆت لە فەیسبووک دەرببڕیت و پەیوەندی لەگەڵ هاوڕێکانت، خێزانەکەت و کەسانی تر بکەیت سەبارەت بەو شتانەی کە گرنگی پێدەدەیت، بۆ نموونە هاوبەشکردنی نوێکارییەکانی دۆخ، وێنە، ڤیدیۆ و چیرۆکەکان لە سەرانسەری ئەو بەرهەمانەی فەیسبووک کە بەکاریان دەهێنیت، ناردنی نامە بۆیان هاوڕێیەک یان چەند کەسێک، یان دروستکردنی ڕووداو یان گروپ، یان زیادکردنی ناوەڕۆک بۆ پڕۆفایلی خۆت. هەروەها ئێمە ڕێگەی نوێمان پەرەپێداوە و بەردەوامین لە دۆزینەوەی، بۆ ئەوەی مرۆڤەکان تەکنەلۆژیا بەکاربهێنن، وەکو واقیعی زیادکراو و ڤیدیۆی ٣٦٠ پلە بۆ دروستکردنی ناوەڕۆکێکی سەرنجڕاکێش و سەرنجڕاکێشتر لە فەیسبووک.' 
                ], JSON_UNESCAPED_UNICODE) ,
        ]);
    }
}
