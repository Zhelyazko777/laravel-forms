<?php

namespace Zhelyazko777\Forms\Handlers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Handlers\Abstractions\BaseControlHandler;
use Illuminate\Database\Eloquent\Model;

class BasicValueHandler extends BaseControlHandler
{
    public function handle(BaseFormControlConfig $config, Model $model, string $propertyName, mixed $value): void
    {
        $propNameParts = explode('.', $propertyName);
        switch (count($propNameParts)) {
            case 1:
                $model->{$propNameParts[0]} = $value;
                break;
            case 2:
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]} = $value;
                $model
                    ->{$propNameParts[0]}
                    ->save();
                break;
            case 3:
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]} = $value;
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->save();
                break;
            case 4:
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]} = $value;
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->save();
                break;
            case 5:
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]} = $value;
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->save();
                break;
            case 6:
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]} = $value;
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->save();
                break;
            case 7:
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]} = $value;
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->save();
                break;
            case 8:
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]}
                    ->{$propNameParts[7]} = $value;
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]}
                    ->save();
                break;
            case 9:
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]}
                    ->{$propNameParts[7]}
                    ->{$propNameParts[8]} = $value;
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]}
                    ->{$propNameParts[7]}
                    ->save();
                break;
            case 10:
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]}
                    ->{$propNameParts[7]}
                    ->{$propNameParts[8]}
                    ->{$propNameParts[9]} = $value;
                $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]}
                    ->{$propNameParts[7]}
                    ->{$propNameParts[8]}
                    ->save();
                break;
            default:
                throw new \Exception("Forms doesn't support more than 10 levels deep relations!");
        }
    }
}
