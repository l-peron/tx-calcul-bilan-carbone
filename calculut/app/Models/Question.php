<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $intitule
 * @property string|null $description
 * @property string $variable
 * @property string $type
 * @property string $formulaire_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Donnee> $donnees
 * @property-read int|null $donnees_count
 * @property-read \App\Models\Formulaire $formulaire
 * @method static \Database\Factories\QuestionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereFormulaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereVariable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Question withoutTrashed()
 * @mixin \Eloquent
 */
class Question extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = ["intitule", "description", "variable", "type"];

    protected $with = ['donnees'];

    protected function casts(): array
    {
        return [
            'intitule' => 'string',
            'description' => 'string',
            'variable' => 'string',
            'type' => 'string',
        ];
    }

    public function donnees(): BelongsToMany
    {
        return $this->belongsToMany(Donnee::class);
    }

    public function formulaire(): BelongsTo
    {
        return $this->belongsTo(Formulaire::class);
    }
}
