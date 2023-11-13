<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabBranchImage extends BaseModel {
    const IMAGEPATH = 'labbranch_images';
    use HasFactory;
    protected $fillable = ['image', 'lab_branch_id'];

    public function lab() {
        return $this->belongsTo(Lab::class);
    }

    public function labBranch() {
        return $this->belongsTo(LabBranch::class);
    }
}
