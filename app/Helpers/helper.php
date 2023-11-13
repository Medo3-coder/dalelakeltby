<?php

use App\Models\Seo;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

function seo($key) {
    return Seo::where('key', $key)->first();
}

function appInformations() {
    $result = SiteSetting::pluck('value', 'key');
    return $result;
}

function convert2english($string) {
    $newNumbers = range(0, 9);
    $arabic     = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $string     = str_replace($arabic, $newNumbers, $string);
    return $string;
}

function fixPhone($string = null) {
    if (!$string) {
        return null;
    }

    $result = convert2english($string);
    $result = ltrim($result, '00');
    $result = ltrim($result, '0');
    $result = ltrim($result, '+');
    return $result;
}

function Translate($text, $lang) {

    $api = 'trnsl.1.1.20190807T134850Z.8bb6a23ccc48e664.a19f759906f9bb12508c3f0db1c742f281aa8468';

    $url = file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?key=' . $api
        . '&lang=ar' . '-' . $lang . '&text=' . urlencode($text));
    $json = json_decode($url);
    return $json->text[0];
}

function getYoutubeVideoId($youtubeUrl) {
    preg_match(
        "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/",
        $youtubeUrl,
        $videoId
    );
    return $youtubeVideoId = isset($videoId[1]) ? $videoId[1] : "";
}

function lang() {
    return App()->getLocale();
}

function generateRandomCode() {
    return '1234';
    return rand(1111, 4444);
}

if (!function_exists('languages')) {
    function languages() {
        return ['ar', 'en', 'kur'];
    }
}

if (!function_exists('defaultLang')) {
    function defaultLang() {
        return 'ar';
    }

    function authUser($guard) {
        return Auth::guard($guard)->user();
    }
}

if (!function_exists('provider')) {
    function provider($guard) {
        $provider = Auth::guard($guard)->user();
        if ($provider->parent_id) {
            $provider = $provider->parent;
        }
        return $provider;
    }
}

if (!function_exists('getUser')) {
    function getUser($order) {
        $user               =   $order->lab_id == null && $order->pharmacist_id != null ? $order->pharmacy : $order->lab;
        return $user;
    }
}

if (!function_exists('getTypeUser')) {
    function getTypeUser($order) {
        $type               =   $order->lab_id == null && $order->pharmacist_id != null ? 'pharmacy' : 'lab';
        return $type;
    }
}

if (!function_exists('getRouteOrder')) {
    function getRouteOrder($order, $type) {
        $route              =   $type == 'lab' ? route($type .'.medicalDevices.myOrderDetails', $order->id): route($type . '.myOrders.details', $order->id);
        return $route;
    }
}

if (!function_exists('getBranch')) {
    function getBranch($order) {
        $branch                     =   $order->lab_branch_id == null && $order->pharmacist_id != null ? $order->pharmacyBranch : $order->labBranch;
        return $branch;
    }
}

if (!function_exists('getProducts')) {
    function getProducts($order) {
        $store = provider('store');
        $orderProducts = $order->orderproducts;
        if (count($orderProducts) > 0){
            foreach ($orderProducts as $orderProduct){
                if ($orderProduct->offer_id != null){
                    $offer          = $store->offers()->find($orderProduct->offer_id);
                    $productsIds    = $offer->products()->pluck('product_id')->toArray();
                    foreach ($store->products()->whereIn('id', $productsIds)->get() as $product)
                        $product->increment('counter', 1);
                        $product->groupOne()->decrement('in_stock_qty',$orderProduct->qty);

                }

                if ($orderProduct->product_id != null){
                    $orderProduct->product()->increment('counter', 1);
                    $orderProduct->product()->first()->groupOne()->decrement('in_stock_qty', $orderProduct->qty);
                }
            }

        }
    }
}


function getDay($day)
{
    $find = array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri");
    if (lang() != 'en') {
        if (lang() == 'ar') {
            $replace = array("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        }else{
            $replace = array("شەمە", "یەکشەممە", "دووشەممە", "سێشەممە", "چوارشەممە", "پێنجشەممە", "هەینی");
        }
        $day = str_replace($find, $replace, $day);
    }
    return $day ;
}
function getFullDay($day)
{
    $find = array("Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
    if (lang() != 'en') {
        if (lang() == 'ar') {
            $replace = array("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        }else{
            $replace = array("شەمە", "یەکشەممە", "دووشەممە", "سێشەممە", "چوارشەممە", "پێنجشەممە", "هەینی");
        }
        $day = str_replace($find, $replace, $day);
    }
    return $day ;
}
