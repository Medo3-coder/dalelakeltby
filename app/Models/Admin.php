<?php

namespace App\Models;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable {
    use Notifiable, UploadTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'avatar',
        'role_id',
        'is_notify',
        'is_blocked',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_notify'  => 'boolean',
        'is_blocked' => 'boolean',
    ];

    public function getAvatarAttribute() {
        if ($this->attributes['avatar']) {
            $image = $this->getImage($this->attributes['avatar'], 'admins');
        } else {
            $image = $this->defaultImage('admins');
        }
        return $image;
    }

    public function scopeSearch($query, $searchArray = []) {
        $query->where(function ($query) use ($searchArray) {
            if ($searchArray) {
                foreach ($searchArray as $key => $value) {
                    if (str_contains($key, '_id')) {
                        $query->Where($key, $value);
                    } elseif ($key == 'order') {
                    } elseif ($key == 'created_at_min') {
                        if ($value != null) {
                            $query->WhereDate('created_at', '>=', $value);
                        }
                    } elseif ($key == 'created_at_max') {
                        if ($value != null) {
                            $query->WhereDate('created_at', '<=', $value);
                        }
                    } else {
                        $query->Where($key, 'like', '%' . $value . '%');
                    }
                }
            }
        });
        return $query->orderBy('created_at', request()->searchArray && request()->searchArray['order'] ? request()->searchArray['order'] : 'DESC');
    }

    public function setAvatarAttribute($value) {
        if (null != $value && is_file($value)) {
            isset($this->attributes['avatar']) ? $this->deleteFile($this->attributes['avatar'], 'admins') : '';
            $this->attributes['avatar'] = $this->uploadAllTyps($value, 'admins');
        }
    }

    public function role() {
        return $this->belongsTo(Role::class)->withTrashed();
    }

    public function setPasswordAttribute($value) {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function replays() {
        return $this->morphMany(ComplaintReplay::class, 'replayer');
    }

    public function rooms() {
        return $this->morphMany(RoomMember::class, 'memberable');
    }

    public function ownRooms() {
        return $this->morphMany(Room::class, 'createable');
    }

    public function joinedRooms() {
        return $this->morphMany(RoomMember::class, 'memberable')
            ->with('room')
            ->get()
            ->sortByDesc('last_message_id')
            ->pluck('room');
    }

    public function transactions() {
        return $this->morphMany(Transaction::class, 'transactionable')->latest();
    }

    public function settlements() {
        return $this->morphMany(Settlement::class, 'transactionable')->latest();
    }

    public function logout() {
        $this->tokens()->delete();
        // $this->currentAccessToken()->delete();
        if (request()->device_id) {
            $this->devices()->where(['device_id' => request()->device_id])->delete();
        }
        return true;
    }

    public function devices() {
        return $this->morphMany(Device::class, 'morph');
    }

    public function notifications() {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');

    }

    public static function boot() {
        parent::boot();
        /* creating, created, updating, updated, deleting, deleted, forceDeleted, restored */

        static::deleted(function ($model) {
            $model->deleteFile($model->attributes['avatar'], 'admins');
        });

    }

}
