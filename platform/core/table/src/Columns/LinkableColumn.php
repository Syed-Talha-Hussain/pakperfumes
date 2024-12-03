<?php

namespace Botble\Table\Columns;

use Botble\Base\Contracts\BaseModel;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Table\Contracts\EditedColumn;

class LinkableColumn extends Column implements EditedColumn
{
    protected array $route = [];

    protected string|null $permission = null;

    public function route(string $route, array $parameters = [], bool $absolute = true): static
    {
        $this->route = [$route, $parameters, $absolute];

        return $this;
    }

    public function getRoute(): array
    {
        return $this->route;
    }

    public function permission(string $permission): static
    {
        $this->permission = $permission;

        return $this;
    }

    public function getPermission(): string|null
    {
        return $this->permission;
    }

    public function editedFormat($value): string
    {
        $item = $this->getModel();

        if (! $item instanceof BaseModel) {
            return $value;
        }

        $value = BaseHelper::clean($value);

        $valueTruncated = $this->applyLimitIfAvailable($value);

        $route = $this->getRoute();

        if (! $route || ! $this->getTable()->hasPermission($this->getPermission() ?: $route[0])) {
            return $valueTruncated ?: '&mdash;';
        }

        $value = Html::link(
            route($route[0], $route[1] ?: $item->getKey(), $route[2]),
            $valueTruncated,
            ['title' => $value]
        );

        return apply_filters('table_name_column_data', $value, $item, $this);
    }
}
