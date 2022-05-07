<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method create(array $all)
 */
class Post extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
  ];
}
