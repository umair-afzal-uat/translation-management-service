<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Locale extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'name'];
}