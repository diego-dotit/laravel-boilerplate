  <li
      role="presentation"
      aria-hidden="true"
      {{ $attributes->twMerge('[&>svg]:w-3.5 [&>svg]:h-3.5') }}
  >
      @if ($slot->isEmpty())
          <x-heroicon-o-chevron-right />
      @else
          {{ $slot }}
      @endif
  </li>
