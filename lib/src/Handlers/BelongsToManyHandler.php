<?php

namespace Zhelyazko777\Forms\Handlers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Handlers\Abstractions\BaseControlHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BelongsToManyHandler extends BaseControlHandler
{
    /**
     * @param  MultiselectFormControlConfig  $config
     * @param  Model  $model
     * @param  string  $propertyName
     * @param  mixed  $value
     */
    public function handle(BaseFormControlConfig $config, Model $model, string $propertyName, mixed $value): void
    {
        /** @var BelongsToMany $relation */
        $relation = $this->getRelationship($model, $propertyName);
        if ($config->getSoftDeleteConnections()) {
            $modelClass = $relation->getPivotClass();
            $tableName = $relation->getTable();
            /** @phpstan-ignore-next-line  */
            $parentId = $relation->getParent()->id;
            $relationColumnName = substr($relation->getRelationName(), 0, -1) . '_' . "id";
            $allMappedRecordIds = call_user_func("$modelClass::withoutGlobalScopes")
                ->where($relation->getForeignPivotKeyName(), $parentId)
                ->select(["$tableName." . $relationColumnName, "$tableName." . 'deleted_at'])
                ->get();
            $mappedRecordIds = $allMappedRecordIds
                ->filter(fn ($x) => is_null($x['deleted_at']))
                ->map(fn ($x) => $x[$relationColumnName])
                ->toArray();
            $deletedMappedRecordIds = $allMappedRecordIds
                ->filter(fn ($x) => !is_null($x['deleted_at']))
                ->map(fn ($x) => $x[$relationColumnName])
                ->toArray();

            $recordsToRemoveIds = array_diff($mappedRecordIds, $value);
            $recordsToRecoverIds = array_intersect($deletedMappedRecordIds, $value);

            if (count($recordsToRemoveIds) > 0) {
                call_user_func("$modelClass::withoutGlobalScopes")
                    ->where($relation->getForeignPivotKeyName(), $parentId)
                    ->whereIn("$tableName.$relationColumnName", $recordsToRemoveIds)
                    ->update([ "$tableName.deleted_at" => now() ]);
            }
            if (count($recordsToRecoverIds) > 0) {
                call_user_func("$modelClass::withoutGlobalScopes")
                    ->where($relation->getForeignPivotKeyName(), $parentId)
                    ->whereIn("$tableName.$relationColumnName", $recordsToRecoverIds)
                    ->update([ "$tableName.deleted_at" => null ]);
            }
            $relation->syncWithoutDetaching($value);
        } else {
            $relation->sync($value);
        }
    }
}
