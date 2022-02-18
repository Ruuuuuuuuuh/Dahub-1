<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $title)
 * @property mixed $name
 */
class Tag extends Model
{
    use HasFactory;
    protected $guarded = [];
}
