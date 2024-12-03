<?php

namespace Botble\Table\Columns;

use Botble\Base\Contracts\BaseModel;
use Botble\Base\Supports\Renderable;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Contracts\EditedColumn;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;
use Yajra\DataTables\Html\Column as BaseColumn;

class Column extends BaseColumn
{
    use Renderable;
    use Conditionable;

    protected TableAbstract $table;

    protected int $limit;

    protected object|array $model;

    public static function make(array|string $data = [], string $name = ''): static
    {
        $instance = parent::make($data, $name);

        if ($instance instanceof EditedColumn) {
            $instance->renderUsing(fn (EditedColumn $column, $value) => $column->editedFormat($value));
        }

        return $instance;
    }

    public function removeClass(string $class): static
    {
        if (isset($this->attributes['className'])) {
            $className = $this->attributes['className'];
            $this->attributes['className'] = trim(str_replace($class, '', $className));
        }

        return $this;
    }

    public function alignLeft(): static
    {
        return $this->alignStart();
    }

    public function alignStart(): static
    {
        return $this->addClass('text-start');
    }

    public function alignCenter(): static
    {
        return $this->addClass('text-center');
    }

    public function alignEnd(): static
    {
        return $this->addClass('text-end');
    }

    public function nowrap(): static
    {
        return $this->addClass('text-nowrap');
    }

    public function fontBold(): static
    {
        return $this->addClass('fw-bold');
    }

    public function fontBolder(): static
    {
        return $this->addClass('fw-bolder');
    }

    public function fontSemibold(): static
    {
        return $this->addClass('fw-semibold');
    }

    public function fontLight(): static
    {
        return $this->addClass('fw-light');
    }

    public function fontLighter(): static
    {
        return $this->addClass('fw-lighter');
    }

    public function fontMono(): static
    {
        return $this->addClass('font-monospace');
    }

    public function underline(): static
    {
        return $this->addClass('text-decoration-underline');
    }

    public function lineThrough(): static
    {
        return $this->addClass('text-decoration-line-through');
    }

    public function limit(int $length = 5): static
    {
        $this->limit = $length;

        return $this;
    }

    public function applyLimitIfAvailable(string|null $text): string
    {
        if (isset($this->limit) && $this->limit > 0) {
            return Str::limit($text, $this->limit);
        }

        return $text ?: '&mdash;';
    }

    public function columnVisibility(bool $has = false): static
    {
        if ($has) {
            return $this->removeClass('no-column-visibility');
        }

        return $this->addClass('no-column-visibility');
    }

    public function setTable(TableAbstract $table): static
    {
        $this->table = $table;

        return $this;
    }

    public function getTable(): TableAbstract
    {
        return $this->table;
    }

    public function setModel(object $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): object
    {
        return $this->model;
    }

    public function renderCell(BaseModel|array $model, TableAbstract $table): string
    {
        $model = $model instanceof BaseModel ? $model : (object)$model;

        $this->setTable($table)->setModel($model);

        return $this->rendering(fn () => $model->{$this->name});
    }
}
