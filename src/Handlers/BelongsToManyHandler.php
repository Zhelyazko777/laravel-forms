<?php

namespace Zhelyazko777\Forms\Handlers;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection;
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
     * @throws \Exception
     */
    public function handle(BaseFormControlConfig $config, Model $model, string $propertyName, mixed $value): void
    {
        /** @var BelongsToMany $relation */
        $relation = $this->getRelationship($model, $propertyName);
        $shouldSoftDeleteConnections = $config->getSoftDeleteConnections();

        if ($shouldSoftDeleteConnections) {
            $pivotTableName = $relation->getTable();
            $relationColumnName = $this->getRelationColumnName($relation);

            $this->removeDeletedAtFilterFromPivot($relation, $pivotTableName);
            $allMappedRecordIds = $relation->get(["$pivotTableName.$relationColumnName", "$pivotTableName.deleted_at"]);

            $recordsToRemoveIds = $this->getRecordsForSoftDelete($allMappedRecordIds, $relationColumnName, $value);
            $recordsToRestoreIds = $this->getRecordsForRestore($allMappedRecordIds, $relationColumnName, $value);

            if (count($recordsToRemoveIds) > 0) {
                $this->softDetachValues(
                    $relation,
                    $pivotTableName,
                    $relationColumnName,
                    $recordsToRemoveIds,
                );
            }
            if (count($recordsToRestoreIds) > 0) {
                $this->restoreSoftDetachedValues(
                    $relation,
                    $pivotTableName,
                    $relationColumnName,
                    $recordsToRestoreIds,
                );
            }
        }

        $relation->sync($value, !$shouldSoftDeleteConnections);
    }

    /**
     * Get the relationship column name
     * @param  BelongsToMany  $relation
     * @return string
     */
    private function getRelationColumnName(BelongsToMany $relation): string
    {
        return substr($relation->getRelationName(), 0, -1) . '_id';
    }

    /**
     * Soft detaches pivot table rows
     * @param  BelongsToMany  $relation
     * @param  string  $pivotTableName
     * @param  string  $relationColumnName
     * @param  array<int>  $recordsToRemoveIds
     */
    private function softDetachValues(
        BelongsToMany $relation,
        string $pivotTableName,
        string $relationColumnName,
        array $recordsToRemoveIds,
    ): void
    {
        $relation
            ->whereIn("$pivotTableName.$relationColumnName", $recordsToRemoveIds)
            ->update([ "$pivotTableName.deleted_at" => now() ]);
    }

    /**
     * Restores soft detached pivot table rows
     * @param  BelongsToMany  $relation
     * @param  string  $pivotTableName
     * @param  string  $relationColumnName
     * @param  array<int>  $recordsToRecoverIds
     */
    private function restoreSoftDetachedValues(
        BelongsToMany $relation,
        string $pivotTableName,
        string $relationColumnName,
        array $recordsToRecoverIds,
    ): void
    {
        $relation
            ->whereIn("$pivotTableName.$relationColumnName", $recordsToRecoverIds)
            ->update([ "$pivotTableName.deleted_at" => null ]);
    }

    /**
     * Restore soft detached values
     * @param  Collection  $allMappedRecordIds
     * @param  string  $relationColumnName
     * @param  mixed  $value
     * @return array<int>
     */
    private function getRecordsForRestore(
        Collection $allMappedRecordIds,
        string $relationColumnName,
        mixed $value
    ): array
    {
        $deletedMappedRecordIds = $allMappedRecordIds
            ->filter(fn ($x) => !is_null($x['deleted_at']))
            ->map(fn ($x) => $x[$relationColumnName])
            ->toArray();

        return array_intersect($deletedMappedRecordIds, $value);
    }

    /**
     * Soft deletes attached values
     * @param  Collection  $allMappedRecordIds
     * @param  string  $relationColumnName
     * @param  mixed  $value
     * @return array<int>
     */
    private function getRecordsForSoftDelete(
        Collection $allMappedRecordIds,
        string $relationColumnName,
        mixed $value
    ): array
    {
        $mappedRecordIds = $allMappedRecordIds
            ->filter(fn ($x) => is_null($x['deleted_at']))
            ->map(fn ($x) => $x[$relationColumnName])
            ->toArray();

        return array_diff($mappedRecordIds, $value);
    }

    /**
     * Removes the deleted at filtration from the relation
     * @param  BelongsToMany  $relation
     * @param  string  $pivotTableName
     */
    private function removeDeletedAtFilterFromPivot(BelongsToMany $relation, string $pivotTableName): void
    {
        $relation->getQuery()->getQuery()->wheres = array_filter(
            $relation->getQuery()->getQuery()->wheres,
            fn ($where) => $where['column'] !== "$pivotTableName.deleted_at" && $where['type'] !== 'Null',
        );
    }
}
