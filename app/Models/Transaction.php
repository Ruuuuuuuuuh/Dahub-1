<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



/**
 * @method static where(string $string, mixed $value)
 */
class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];
}
