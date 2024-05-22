<?php

namespace Tests\Unit;

use App\Models\Donnee;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonneeTest extends TestCase
{
    use RefreshDatabase, InteractsWithDatabase;

    public function test_creer_une_donnee(): void
    {
        $donnee = Donnee::factory()->create();
        $this->assertModelExists($donnee);
    }

    public function test_supprimer_une_donnee(): void
    {
        $donnee = Donnee::factory()->create();
        $donnee->delete();
        $this->assertSoftDeleted($donnee);
    }
}
