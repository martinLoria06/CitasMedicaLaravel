<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelAppintment extends Model
{
    use HasFactory;

    public function cancelled_by(){
        return $this->belongsTo(User::class);
    }
}
