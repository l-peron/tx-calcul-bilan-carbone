<?php

namespace Tests\Unit;

use App\Models\Bilan;
use Tests\TestCase;

class BilanTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_creer_un_bilan(): void
    {
        $donnee = Bilan::factory()->create();
        $this->assertModelExists($donnee);
    }

    public function test_supprimer_un_bilan(): void
    {
        $donnee = Bilan::factory()->create();
        $donnee->delete();
        $this->assertSoftDeleted($donnee);
    }
}
