<?php

namespace Botble\Table\Columns;

use Botble\Base\Models\BaseModel;
use Botble\Table\Contracts\EditedColumn;

class IdColumn extends Column implements EditedColumn
{
    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data ?: 'id', $name)
            ->title(trans('core/base::tables.id'))
            ->alignCenter()
            ->width(20)
            ->columnVisibility()
            ->when(BaseModel::getTypeOfId() !== 'BIGINT', function (IdColumn $column) {
                return $column->limit();
            });
    }

    public function editedFormat($value): string|null
    {
        return $this->applyLimitIfAvailable($value);
    }
}
