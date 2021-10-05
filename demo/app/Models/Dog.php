<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Dog
 *
 * @property int $id
 * @property string $name
 * @property int $owner_id
 * @method static \Illuminate\Database\Eloquent\Builder|Dog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dog whereOwnerId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Owner $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Toy[] $toys
 * @property-read int|null $toys_count
 */
class Dog extends Model
{
    use HasFactory;

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function toys(): BelongsToMany
    {
        return $this->belongsToMany(Toy::class);
    }
}
