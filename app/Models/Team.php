<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $owner_id
 */
class Team extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
}
