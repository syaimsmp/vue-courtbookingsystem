<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Court;
use App\Models\User;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['court_name', 'user_name'];

    public function court(){
        return $this->belongsTo(Court::class);
    }

    public function getCourtNameAttribute(){
        if($this->court){
            return $this->court->name;
        }
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getUserNameAttribute(){
        if($this->user){
            return $this->user->name;
        }
    }
}
