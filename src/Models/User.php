<?php

declare(strict_types = 1);

namespace App\Models;


class User extends Model
{
    protected $table = "users";

    protected $fillable = ['nombres', 'apellidos', 'correo'];
}