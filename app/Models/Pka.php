<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;

class Pka extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "email",
        "password",
        "phone_number"
    ];
}
