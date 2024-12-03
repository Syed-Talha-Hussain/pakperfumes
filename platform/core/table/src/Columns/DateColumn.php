<?php

namespace Botble\Table\Columns;

use Botble\Base\Facades\BaseHelper;
use Botble\Table\Contracts\EditedColumn;

class DateColumn extends Column implements EditedColumn
{
    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data, $name)
            ->type('date')
            ->width(100);
    }

    public function editedFormat($value): string
    {
        if (! $value) {
            return '&mdash;';
        }

        return BaseHelper::formatDate($value);
    }
}
