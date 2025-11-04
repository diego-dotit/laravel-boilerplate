<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait CrudForm
{
    abstract public function getModel(): string;
    abstract public function getRedirectRoute(): string;
    abstract public function getValidationRules(): array;
    abstract public function processModelBeforeSave(): void;

    public ?Model $model = null;

    public function doRedirect(): bool
    {
        return true;
    }

    public function isEditMode(): bool
    {
        return $this->model && $this->model->exists;
    }

    public function loadModelData(): void
    {
        if ($this->model) {
            $this->fill($this->model->toArray());
        }
    }

    public function mount(...$params): void
    {
        $this->beforeMount();

        $modelClass = $this->getModel();

        $id = null;

        foreach($params as $param) {
            if($param instanceof Model && $param instanceof $modelClass) {
                $id = $param;
                break;
            }
        }

        if ($id) {
            if($id instanceof Model) {
                $this->model = $id;
            } else {
                $this->model = $modelClass::find($id);
            }

            $this->loadModelData();
        } else {
            $this->model = new $modelClass();
        }

        $this->afterMount();
    }

    public function beforeMount(): void
    {

    }

    public function afterMount(): void
    {

    }

    public function processModelAfterSave(): void
    {

    }

    public function save(): void
    {
        try {
            $validatedData = $this->validate($this->getValidationRules());
        } catch (ValidationException $e) {
            $this->dispatch(
                'alert',
                __('common.save_error'),
                __('common.save_error_description'),
                'destructive',
                'exclamation-circle'
            );

            throw $e;
        }

        $this->dispatch('form-saving', $this->model);

        $this->processModelBeforeSave();

        $this->model->save();

        $this->processModelAfterSave();

        if($this->doRedirect()) {
            session()->flash(
                'alert',
                $this->isEditMode() ? [
                    'title' => __('common.updated_successfully'),
                    'description' => __('common.updated_successfully_description'),
                    'variant' => 'success',
                    'icon' => 'check-badge'
                ] : [
                    'title' => __('common.created_successfully'),
                    'description' => __('common.created_successfully_description'),
                    'variant' => 'success',
                    'icon' => 'check-badge'
                ]
            );

            $this->redirectRoute($this->getRedirectRoute(), $this->model);
        } else {
            $this->dispatch('form-saved', $this->model);
            $this->dispatch(
                'alert',
                $this->isEditMode() ? __('common.updated_successfully') : __('common.created_successfully'),
                $this->isEditMode() ? __('common.updated_successfully_description') : __('common.created_successfully_description'),
                'success',
                'check-badge'
            );

            $this->model = new ($this->getModel())();

            foreach(array_keys($validatedData) as $field) {
                if(property_exists($this, $field)) {
                    switch(gettype($this->$field)) {
                        case 'boolean':
                            $this->$field = false;
                            break;
                        case 'integer':
                            $this->$field = 0;
                            break;
                        case 'array':
                            $this->$field = [];
                            break;
                        case 'string':
                            $this->$field = '';
                            break;
                        default:
                            $this->$field = null;
                    }
                }
            }

            $this->resetValidation();
        }
    }

    public function processSingleImageSave(mixed $image, string $collectionName): void
    {
        if($image !== null) {
            $this->model->clearMediaCollection($collectionName);
        }

        if($image) {
            if(is_string($image)) {
                if(str_starts_with($image, 'livewire-file:')) {
                    $image = str_replace('livewire-file:', '', $image);
                }
                $image = TemporaryUploadedFile::createFromLivewire($image);
            }

            $this->model->addMedia($image->getRealPath())
                ->usingFileName(uniqid() . '.' . $image->getClientOriginalExtension())
                ->toMediaCollection($collectionName);
        }
    }

    public function processMultipleImagesSave(array $images, string $collectionName): void
    {
        foreach($images as $image) {
            if(is_string($image['file']) && str_starts_with($image['file'], 'media:')) {
                $mediaId = str_replace('media:', '', $image['file']);
                $mediaItem = $this->model->getMedia($collectionName)->where('id', $mediaId)->first();

                if($mediaItem && isset($image['removed'])) {
                    $mediaItem->delete();
                }

                continue;
            }

            if(isset($image['removed'])) {
                continue;
            }

            if(is_string($image['file'])) {
                if(str_starts_with($image['file'], 'livewire-file:')) {
                    $image['file'] = str_replace('livewire-file:', '', $image['file']);
                }
                $image['file'] = TemporaryUploadedFile::createFromLivewire($image['file']);
            }

            $this->model->addMedia($image['file']->getRealPath())
                ->usingFileName(uniqid() . '.' . $image['file']->getClientOriginalExtension())
                ->toMediaCollection($collectionName);
        }
    }
}
