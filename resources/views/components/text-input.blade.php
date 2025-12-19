@props(['disabled' => false])

<input {{ $attributes->merge(['class' => 'form-control']) }} @if($disabled) disabled @endif />
