<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait CrudListing
{
    abstract public function getModel(): string;
    abstract public function getColumns(): array;
    abstract public function getResults(): LengthAwarePaginator;

    public function delete(int $id): void
    {
        try {
            $model = $this->getModel();
            $record = $model::findOrFail($id);
            $record->delete();

            $this->dispatch(
                'alert',
                __('common.deleted_successfully'),
                __('common.deleted_successfully_description'),
                'success',
                'check-badge'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'alert',
                __('common.deleted_error'),
                __('common.deleted_error_description'),
                'destructive',
                'exclamation-circle'
            );
        }
    }
}
