<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Enquiry extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    public function getUsers() {
        return $this->belongsTo(User::class, 'user_id');
        // return $this->hasMany(User::class,'id', 'user_id');
    }
}
