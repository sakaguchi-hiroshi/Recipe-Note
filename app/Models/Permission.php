<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public static $rules = array(
        'name' => 'required',
    );

    public function users(){
        return $this->hasMany('App\Models\Users', 'permission_id');
    }
}
