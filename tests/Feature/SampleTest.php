<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class SampleTest extends TestCase
{
    use RefreshDatabase;
    public function test(): void
    {
        $user1 = User::create(['name' => Str::random(), 'id' => 3]);
        $user2 = User::create(['name' => Str::random(), 'id' => 4]);

        $team1 = Team::create(['owner_id' => $user1->id]);
        $team2 = Team::create(['owner_id' => $user2->id]);

        $teamMate1 = User::create(['name' => 'John', 'slug' => 'john-slug', 'team_id' => $team1->id, 'id' => 2]);
        $teamMate2 = User::create(['name' => 'Jane', 'slug' => 'jane-slug', 'team_id' => $team2->id, 'id' => $team1->id]);

        $this->assertSame(2, $teamMate1->id);
        $this->assertSame(1, $teamMate2->id);

        $this->assertSame(2, $teamMate1->refresh()->id);
        $this->assertSame(1, $teamMate2->refresh()->id);

        $this->assertSame('john-slug', $teamMate1->slug);
        $this->assertSame('jane-slug', $teamMate2->slug);

        $this->assertSame('john-slug', $teamMate1->refresh()->slug);
        $this->assertSame('jane-slug', $teamMate2->refresh()->slug);

        DB::enableQueryLog();
        $user1->teamMates()->updateOrCreate([
            'name' => 'John',
        ], [
            'slug' => 'john-doe',
        ]);
        dump(DB::getRawQueryLog());

        $this->assertSame('john-doe', $teamMate1->fresh()->slug);
        $this->assertSame('jane-slug', $teamMate2->fresh()->slug);
    }
}
