<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string $title
 * @property mixed $value
 */
class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'value',
    ];

}
