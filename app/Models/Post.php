<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

     public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

      public function Admin()
    {
        return $this->hasOne(Admin::class, 'id', 'admin_id');
    }

}
