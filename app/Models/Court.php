<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;
use App\Models\User;


class Court extends Model
{
    use HasFactory;

    public function booking(){
        return $this->hasMany(Booking::class);
    }

    public function user(){
        return $this->belongsToMany(User::class, );
    }
}
