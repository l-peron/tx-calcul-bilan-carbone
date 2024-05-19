<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $intitule
 * @property string $type
 * @property string $auteur
 * @property string $asso
 * @property string $pole_asso
 * @property array|null $enregistrement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EnregistrementFinalise> $enregistrementFinalises
 * @property-read int|null $enregistrement_finalises_count
 * @property-read \App\Models\Evenement|null $evenement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Formulaire> $formulaires
 * @property-read int|null $formulaires_count
 * @method static \Database\Factories\BilanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan whereAsso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan whereAuteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan whereEnregistrement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan wherePoleAsso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bilan withoutTrashed()
 * @mixin \Eloquent
 */
class Bilan extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = ["intitule", "type", "auteur", "asso", "pole_asso", "enregistrement"];

    protected function casts(): array
    {
        return [
          'intitule' => 'string',
            'type' => 'string',
            'auteur' => 'string',
            'asso' => 'string',
            'pole_asso' => 'string',
            'enregistrement' => 'array',
        ];
    }

    public function formulaires(): BelongsToMany
    {
        return $this->belongsToMany(Formulaire::class);
    }

    public function evenement(): HasOne
    {
        return $this->hasOne(Evenement::class);
    }

    public function enregistrementFinalises(): HasMany
    {
        return $this->hasMany(EnregistrementFinalise::class);
    }
}
