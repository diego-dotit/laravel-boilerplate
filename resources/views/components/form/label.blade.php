@props(['required' => false])

<x-label x-form:label {{ $attributes }}>
    {{ $slot }} @if($required) <b class="text-red-500 font-900">*</b> @endif
</x-label>
