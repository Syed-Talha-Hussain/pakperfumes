<?php

namespace Botble\Table\Columns;

use Botble\Base\Facades\Form;
use Botble\Table\Contracts\EditedColumn;

class CheckboxColumn extends Column implements EditedColumn
{
    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data ?: 'checkbox', $name)
            ->content('')
            ->title(
                Form::input('checkbox', '', null, [
                    'class' => 'form-check-input m-0 align-middle table-check-all',
                    'data-set' => '.dataTable .checkboxes',
                ])->toHtml()
            )
            ->width(20)
            ->alignLeft()
            ->orderable(false)
            ->exportable(false)
            ->searchable(false)
            ->columnVisibility()
            ->titleAttr(trans('core/base::tables.checkbox'));
    }

    public function editedFormat($value): string
    {
        return view('core/table::partials.checkbox', [
            'id' => $this->getModel()->getKey(),
        ])->render();
    }
}
