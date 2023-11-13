<?php

namespace App\Models;

class SiteMessage extends BaseModel {
    const IMAGEPATH = 'sitemessages';

    protected $fillable = [
        'name',
        'country_code',
        'phone',
        'message',
    ];
}
