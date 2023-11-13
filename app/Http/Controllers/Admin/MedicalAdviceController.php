<?php

namespace App\Http\Controllers\Admin;

use App\Builders\Input;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\medicaladvices\Store;
use App\Http\Requests\Admin\medicaladvices\Update;
use App\Models\MedicalAdvice;
use App\Models\MedicalAdviceImage;
use App\Traits\Report;
use Illuminate\Http\Request;

class MedicalAdviceController extends Controller {
    private function inputs($options = null) {
        return [
            'title'       => Input::createArEnInput(__('admin.title_ar'), __('admin.title_en'), __('admin.title_kur'))->build(),
            'description' => Input::createArEnTextarea(__('admin.description_ar'), __('admin.description_en'), __('admin.description_kur'))->colMd(12)->build(),
            'images'      => Input::filesInput(__('admin.images'), $options['images'] ?? [], 'image')
                ->deleteRoute(route('admin.medicaladvices.deleteImage'))
                ->attribute('accept', 'image/png, image/jpg, image/jpeg')
                ->build(),
        ];
    }

    public function index($id = null) {
        if (request()->ajax()) {
            $medicaladvices = MedicalAdvice::search(request()->searchArray)->paginate(30);
            $html           = view('admin.medicaladvices.table', compact('medicaladvices'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.medicaladvices.index');
    }

    public function create() {
        return view('admin.medicaladvices.create', ['inputs' => $this->inputs()]);
    }

    public function store(Store $request) {
        $advice = MedicalAdvice::create($request->validated());
        foreach ($request->images as $image) {
            MedicalAdviceImage::create([
                'image'             => $image,
                'medical_advice_id' => $advice->id,
            ]);
        }
        Report::addToLog('  اضافه نصيحة طبية');
        return response()->json(['url' => route('admin.medicaladvices.index')]);
    }
    public function edit($id) {
        $medicaladvice = MedicalAdvice::with('images')->findOrFail($id);
        $images        = $medicaladvice->images;
        return view('admin.medicaladvices.edit', ['item' => $medicaladvice, 'inputs' => $this->inputs([
            'images' => $images,
        ])]);
    }

    public function update(Update $request, $id) {
        $medicaladvice = MedicalAdvice::findOrFail($id);
        $medicaladvice->update($request->validated());
        if (isset($request->images)) {
            foreach ($request->images as $image) {
                MedicalAdviceImage::create([
                    'image'             => $image,
                    'medical_advice_id' => $medicaladvice->id,
                ]);
            }
        }

        Report::addToLog('  تعديل نصيحة طبية');
        return response()->json(['url' => route('admin.medicaladvices.index')]);
    }

    public function show($id) {
        $medicaladvice = MedicalAdvice::with('images')->findOrFail($id);
        $images        = $medicaladvice->images;
        return view('admin.medicaladvices.show', ['item' => $medicaladvice, 'inputs' => $this->inputs([
            'images' => $images,
        ])]);
    }
    public function deleteImage(Request $request) {
        $image = MedicalAdviceImage::findOrFail($request->id);
        $image->delete();
        return response()->json(['id' => $request->id]);
    }

    public function destroy($id) {
        $medicaladvice = MedicalAdvice::with('images')->findOrFail($id);
        $medicaladvice->images->each->delete();
        $medicaladvice->delete();

        Report::addToLog('  حذف نصيحة طبية');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if ($advices = MedicalAdvice::with('images')->WhereIn('id', $ids)->get()) {
            foreach ($advices as $medicaladvice) {
                $medicaladvice->images->each->delete();
                $medicaladvice->delete();
            }
            Report::addToLog('  حذف العديد من النصائح الطبية');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
