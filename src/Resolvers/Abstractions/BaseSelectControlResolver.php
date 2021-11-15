<?php

namespace Zhelyazko777\Forms\Resolvers\Abstractions;

use Illuminate\Database\Eloquent\Builder;
use Zhelyazko777\Forms\Resolvers\Contracts\ControlResolverInterface;

abstract class BaseSelectControlResolver implements ControlResolverInterface
{
    /**
     * @param  array<mixed>  $options
     * @return array<mixed>
     * @throws \Exception
     */
    protected function getFixedSelectOptions(array $options): array
    {
        if (array_key_exists('value', $options) && array_key_exists('text', $options)) {
            throw new \Exception('Fixed select options should have both text and value property.');
        }

        return $options;
    }

    /**
     * @param  Builder  $query
     * @param  string  $textProp
     * @param  string  $valueProp
     * @return array<mixed>
     */
    protected function getQuerySelectOptions(Builder $query,  string $textProp, string $valueProp): array
    {
        return $query->get([ $valueProp . ' as value', $textProp . ' as text' ])->toArray();
    }
}