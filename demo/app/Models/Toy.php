<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Toy
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|Toy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Toy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Toy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Toy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Toy whereName($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dog[] $dogs
 * @property-read int|null $dogs_count
 */
class Toy extends Model
{
    use HasFactory;

    public function dogs(): BelongsToMany
    {
        return $this->belongsToMany(Dog::class);
    }
}
