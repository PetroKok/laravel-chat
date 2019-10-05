<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['name'];

    /** START RELATIONSHIP **/
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
    /** END RELATIONSHIP **/

    public static function createByCurrentUser(){
        return static::create([
            'name' => uniqid(),
            'user_id' => uniqid(),
        ]);
    }
}
