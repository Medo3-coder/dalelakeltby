<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StatusAcceptedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                    =>  'required|exists:orders,id',
            'prepare_time'          =>  'required|string|min:3|max:255',
            'deliver_date'          =>  'required|date|after:' . Carbon::now()->subDay()->format('d-m-Y')
        ];
    }

    public function attributes()
    {
        return [
            'prepare_time'          =>  __('store.prepare_time'),
            'deliver_date'          =>  __('store.deliver_date'),
        ];
    }
}
