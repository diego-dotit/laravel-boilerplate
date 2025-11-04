<div
    class="relative"
    x-data="{
        init() {
            flatpickr(this.$el.querySelector('input'), {
                dateFormat: 'Y-m-d',
                locale: {
                    firstDayOfWeek: 1,
                },
            });
        }
    }"
>
    <input
        type="text"
        {{ $attributes->twMerge('flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 read-only:cursor-pointer') }}
        readonly
    />

    <x-heroicon-o-calendar
        class="absolute w-5 h-5 -translate-y-1/2 right-2 top-1/2 text-muted-foreground"
    />
</div>
