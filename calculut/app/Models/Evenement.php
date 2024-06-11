<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $debut
 * @property int $fin
 * @property string $description
 * @property string $bilan_id
 * @property-read \App\Models\Bilan|null $bilan
 * @method static \Database\Factories\EvenementFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereBilanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Evenement withoutTrashed()
 * @mixin \Eloquent
 */
class Evenement extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = ["debut", "fin", "description"];

    protected function casts(): array
    {
        return [
          'debut' => 'timestamp',
          'fin' => 'timestamp',
          'description' => 'string'
        ];
    }

    public function bilan(): HasOne
    {
        return $this->hasOne(Bilan::class);
    }
}
