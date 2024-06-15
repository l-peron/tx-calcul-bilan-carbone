<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $intitule
 * @property string|null $description
 * @property string $secteur
 * @property array $formule
 * @property bool $publie
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bilan> $bilans
 * @property-read int|null $bilans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @method static \Database\Factories\FormulaireFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire whereFormule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire wherePublie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire whereSecteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Formulaire withoutTrashed()
 * @mixin \Eloquent
 */
class Formulaire extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = ["intitule", "description", "secteur", "formule", "publie"];

    protected function casts(): array
    {
        return [
          'intitule' => 'string',
          'description' => 'string',
          'secteur' => 'string',
          'formule' => 'array',
            'publie' => 'boolean',
        ];
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function bilans(): BelongsToMany
    {
        return $this->belongsToMany(Bilan::class);
    }

    protected static function booted(): void
    {
        static::deleting(function (Formulaire $formulaire) {
            $formulaire->questions()->delete();
        });
    }
}
