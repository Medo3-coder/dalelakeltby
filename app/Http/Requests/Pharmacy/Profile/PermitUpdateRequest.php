<?php

namespace App\Http\Requests\Pharmacy\Profile;

use Illuminate\Foundation\Http\FormRequest;

class PermitUpdateRequest extends FormRequest
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
            'graduation_certification_image'        =>  'nullable|image',
            'graduation_certification_pdf'          =>  'nullable|mimes:pdf',
            'practice_certification_image'          =>  'nullable|image',
            'practice_certification_pdf'            =>  'nullable|mimes:pdf',
            'experience_certification_image'        =>  'nullable|image',
            'experience_certification_pdf'          =>  'nullable|mimes:pdf',
        ];
    }


}
