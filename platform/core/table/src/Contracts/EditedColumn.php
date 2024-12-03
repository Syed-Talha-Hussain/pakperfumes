<?php

namespace Botble\Table\Contracts;

interface EditedColumn
{
    public function editedFormat($value): string|null;
}
