<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\Offer;

class MedicalDeviceController extends Controller {

    public function offers() {
        $offers = Offer::with('store')->where(['type' => 'equipment'])->whereDate('end_offer', '>', now())->orderBy('updated_at', 'desc')->paginate(9);
        return view('providers_dashboards.lab.medical_devices.offers', compact('offers'));
    }

    public function offerDetails($id) {
        $offer = Offer::findOrFail($id);
        return view('providers_dashboards.lab.medical_devices.offer_details', compact('offer'));
    }

    public function myOrders() {
        $orders = provider('lab')->orders()->with('store')->whereNotIn('status', ['rejected', 'canceled'])->orderBy('created_at', 'desc')->paginate(9);
        return view('providers_dashboards.lab.medical_devices.my_orders', compact('orders'));
    }

    public function myOrderDetails($id) {
        $order = provider('lab')->orders()->with('lab', 'orderproducts', 'orderproducts.offer', 'orderproducts.product', 'installments')->findOrFail($id);
        return view('providers_dashboards.lab.medical_devices.order_details', compact('order'));
    }

}
