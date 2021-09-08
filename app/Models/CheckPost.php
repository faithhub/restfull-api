<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'website_id',
        'post_id',
        'subscriber_id'
    ];
}
