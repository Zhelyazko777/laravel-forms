<?php

namespace Zhelyazko777\Forms\Builders\Models;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseSelectFormControlConfig;

class MultiselectFormControlConfig extends BaseSelectFormControlConfig
{
    private bool $softDeleteConnections = false;

    /**
     * @return bool
     */
    public function getSoftDeleteConnections(): bool
    {
        return $this->softDeleteConnections;
    }

    /**
     * @param  bool  $softDeleteConnections
     * @return self
     */
    public function setSoftDeleteConnections(bool $softDeleteConnections): self
    {
        $this->softDeleteConnections = $softDeleteConnections;
        return $this;
    }
}
