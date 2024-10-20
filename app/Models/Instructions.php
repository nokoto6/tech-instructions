<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructions extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'description',
        'file',
        'uploader_id',
        'accepted',
        'category_id'
    ];
}
