<?php

namespace Zhelyazko777\Forms\Handlers\Abstractions;

use Zhelyazko777\Forms\Handlers\Contracts\ControlHandlerInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

abstract class BaseControlHandler implements ControlHandlerInterface
{
    protected function getRelationship(Model $model, string $propertyName): Relation
    {
        $propNameParts = explode('.', $propertyName);
        switch (count($propNameParts)) {
            case 1:
                return $model->{$propNameParts[0]}();
            case 2:
                return $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}();
            case 3:
                return $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}();
            case 4:
                return $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}();
            case 5:
                return $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}();
            case 6:
                return $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}();
            case 7:
                return $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]}();
            case 8:
                return $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]}
                    ->{$propNameParts[7]}();
            case 9:
                return $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]}
                    ->{$propNameParts[7]}
                    ->{$propNameParts[8]}();
            case 10:
                return $model
                    ->{$propNameParts[0]}
                    ->{$propNameParts[1]}
                    ->{$propNameParts[2]}
                    ->{$propNameParts[3]}
                    ->{$propNameParts[4]}
                    ->{$propNameParts[5]}
                    ->{$propNameParts[6]}
                    ->{$propNameParts[7]}
                    ->{$propNameParts[8]}
                    ->{$propNameParts[9]}();
            default:
                throw new \Exception("Forms doesn't support more than 10 levels deep relations!");
        }
    }
}
