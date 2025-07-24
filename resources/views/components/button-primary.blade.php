@props(['btnType' => 'primary', 'classes' => '', 'furtherActions' => '', 'isLink' => false, 'href' => ''])

@if ($isLink)
    <a class="btn btn-{{ $btnType }} {{ $classes }}" {{ $furtherActions }} href="{{ $href }}">{{ $slot }}</a>
@else
    <button class="btn btn-{{ $btnType }} {{ $classes }}" {{ $furtherActions }}>{{ $slot }}</button>
@endif