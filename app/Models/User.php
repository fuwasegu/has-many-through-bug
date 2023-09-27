<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $team_id
 */
class User extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function teamMates(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Team::class, 'owner_id', 'team_id');
    }
}
