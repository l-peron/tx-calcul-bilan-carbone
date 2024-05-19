<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $auteur
 * @property array $enregistrement
 * @property string $commentaire
 * @property string $bilan_id
 * @property-read \App\Models\Bilan $bilan
 * @method static \Database\Factories\EnregistrementFinaliseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise whereAuteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise whereBilanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise whereEnregistrement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EnregistrementFinalise withoutTrashed()
 * @mixin \Eloquent
 */
class EnregistrementFinalise extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    protected $fillable = ["auteur", "enregistrement", "commentaire"];

    protected function casts(): array
    {
        return [
          'auteur' => 'string',
            'enregistrement' => 'array',
            'commentaire' => 'string',
        ];
    }

    public function bilan(): BelongsTo
    {
        return $this->belongsTo(Bilan::class);
    }
}
