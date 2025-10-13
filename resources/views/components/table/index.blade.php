@props([
    'columns' => [],
])

<div class="overflow-hidden border border-gray-200 rounded-lg">
    <table class="w-full text-left table-auto min-w-max">
        @if(!empty($columns))
            <thead>
                <tr class="bg-gray-50">
                    @foreach($columns as $column)
                        <th class="p-4 border-b border-gray-200 {{ is_array($column) && isset($column[1]) ? $column[1] : '' }}">
                            <span class="block text-sm font-semibold leading-none">
                                {{ is_array($column) ? $column[0] : $column }}
                            </span>
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
