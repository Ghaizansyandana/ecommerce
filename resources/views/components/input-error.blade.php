@props(['messages'])

@if($messages)
    @foreach((array) $messages as $message)
        <div {{ $attributes->merge(['class' => 'text-danger small']) }}>{{ $message }}</div>
    @endforeach
@endif
