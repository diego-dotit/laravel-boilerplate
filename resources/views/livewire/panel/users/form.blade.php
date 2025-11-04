<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Traits\CrudForm;
use App\Factories\UserRoleFactory;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

new class extends Component {
    use CrudForm, WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $role = 'user';
    public string $password = '';
    public string $confirm_password = '';

    public $avatar = null;

    public function processModelBeforeSave(): void
    {
        $this->model->name = $this->name;
        $this->model->email = $this->email;
        $this->model->role = $this->role;

        if($this->password) {
            $this->model->password = bcrypt($this->password);
        }
    }

    public function processModelAfterSave(): void
    {
        $this->processSingleImageSave($this->avatar, 'avatars');
    }

    public function getModel(): string
    {
        return User::class;
    }

    public function getRedirectRoute(): string
    {
        return 'admin.users';
    }

    public function getValidationRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['required', 'in:' . implode(',', UserRoleFactory::getRoles())],
            'password' => [$this->isEditMode() ? 'nullable' : 'required', 'string', 'min:6', 'confirmed:password'],
            'confirm_password' => [$this->isEditMode() ? 'nullable' : 'required', 'string', 'min:6', 'same:password'],
        ];
    }
}; ?>

<x-form wire:model="model" wire:submit="save" class="space-y-4" id="user-form">
    <div class="text-lg font-semibold">{{ __($this->isEditMode() ? 'common.edit' : 'common.create', ['object' => __('admin.users.singular')]) }}</div>

    <x-form.input
        label="{{ __('admin.users.fields.name.label') }}"
        wire:model="name"
        placeholder="{{ __('admin.users.fields.name.placeholder') }}"
    />

    <x-form.input
        label="{{ __('admin.users.fields.email.label') }}"
        wire:model="email"
        type="email"
        placeholder="{{ __('admin.users.fields.email.placeholder') }}"
    />

    <x-form.item>
        <x-form.label>{{ __('admin.users.fields.role.label') }}</x-form.label>
        <x-select wire:model="role">
            @foreach (UserRoleFactory::getLabels() as $key => $label)
                @if($key === 'guest') @continue @endif
                <option value="{{ $key }}">{{ $label }}</option>
            @endforeach
        </x-select>
        <x-form.message />
    </x-form.item>

    @if($this->isEditMode())
        <p class="text-sm text-gray-500">{{ __('admin.users.fields.password.optional') }}</p>
    @endif

    <x-form.input
        label="{{ __('admin.users.fields.password.label') }}"
        wire:model="password"
        type="password"
        placeholder="{{ __('admin.users.fields.password.placeholder') }}"
        autocomplete="new-password"
    />

    <x-form.input
        label="{{ __('admin.users.fields.confirm_password.label') }}"
        wire:model="confirm_password"
        type="password"
        placeholder="{{ __('admin.users.fields.confirm_password.placeholder') }}"
        autocomplete="new-password"
    />

    <livewire:panel.components.image-upload
        wire:model="avatar"
        label="{{ __('admin.users.fields.avatar.label') }}"
        :thumbnail="$this->model->getFirstMediaUrl('avatars', 'preview') ?? null"
    />

    <x-button type="submit">{{ __('button.save') }}</x-button>
</x-form>
