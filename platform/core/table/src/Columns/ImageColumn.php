<?php

namespace Botble\Table\Columns;

use Botble\Base\Facades\Html;
use Botble\Media\Facades\RvMedia;
use Botble\Table\Contracts\EditedColumn;

class ImageColumn extends Column implements EditedColumn
{
    protected bool $relative = false;

    protected int $width = 50;

    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data ?: 'image', $name)
            ->title(trans('core/base::tables.image'))
            ->orderable(false)
            ->searchable(false)
            ->width(50);
    }

    public function relative(bool $flag = true): static
    {
        $this->relative = $flag;

        return $this;
    }

    public function with(int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function editedFormat($value): string
    {
        $table = $this->getTable();

        if ($table->request()->has('action')) {
            if ($table->isExportingToCSV()) {
                return (string) RvMedia::getImageUrl($value, null, $this->relative, RvMedia::getDefaultImage());
            }

            if ($table->isExportingToExcel()) {
                return (string) RvMedia::getImageUrl($value, 'thumb', $this->relative, RvMedia::getDefaultImage());
            }
        }

        return Html::image(
            RvMedia::getImageUrl($value, 'thumb', $this->relative, RvMedia::getDefaultImage()),
            trans('core/base::tables.image'),
            ['width' => $this->width]
        )->toHtml();
    }
}
