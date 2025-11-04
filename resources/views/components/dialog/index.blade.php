<div
    x-data="{
        __dialogOpen: false,
        init: () => {
            $watch('__dialogOpen', value => {
                if (value) {
                    document.body.classList.add('overflow-hidden');
                } else {
                    document.body.classList.remove('overflow-hidden');
                }
            });
        },
    }"
    x-modelable="__dialogOpen"
    x-on:dialog-open="__dialogOpen = true"
    x-on:dialog-close="__dialogOpen = false"
    x-on:dialog-toggle="__dialogOpen = !__dialogOpen"
    {{ $attributes->twMerge('') }}
>
    {{ $slot }}
</div>
