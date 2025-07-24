@props(['btnType' => 'primary', 'classes' => '', 'furtherActions' => ''])

<button class="btn btn-{{ $btnType }} {{ $classes }}" {{ $furtherActions }}>{{ $slot }}</button>