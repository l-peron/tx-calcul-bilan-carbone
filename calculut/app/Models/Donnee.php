<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 * @property float $valeur
 * @property string $unite
 * @property string $source
 * @property string $metrique
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @method static \Database\Factories\DonneeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee whereMetrique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee whereUnite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee whereValeur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Donnee withoutTrashed()
 * @mixin \Eloquent
 */
class Donnee extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = ["intitule", "description", "valeur", "unite", "source", "metrique"];

    protected function casts(): array
    {
        return [
            'intitule' => 'string',
            'description' => 'string',
            'valeur' => 'float',
            'unite' => 'string',
            'source' => 'string',
            'metrique' => 'string',
        ];
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class);
    }
}
