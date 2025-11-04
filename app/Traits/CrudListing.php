<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

trait CrudListing
{
    abstract public function getModel(): string;
    abstract public function getColumns(): array;
    abstract public function getResults(): LengthAwarePaginator;

    public function beforeDelete(Model $model): void
    {
        // Hook for actions before deletion
    }

    public function delete(int $id): void
    {
        try {
            $model = $this->getModel();
            $record = $model::findOrFail($id);
            $this->beforeDelete($record);
            $record->delete();

            $this->dispatch(
                'alert',
                __('common.deleted_successfully'),
                __('common.deleted_successfully_description'),
                'success',
                'check-badge'
            );
            $this->dispatch('delete-success');
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
