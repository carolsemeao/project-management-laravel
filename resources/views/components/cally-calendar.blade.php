<input type="hidden" id="{{ $popoverAnchor }}" name="{{ $popoverAnchor }}"
    value="{{ $initialValue ?: old($popoverAnchor) }}">

<button popovertarget="{{ $popoverTarget }}-popover" type="button"
    class="input input-border w-full text-left flex items-center" id="{{ $popoverAnchor }}_display"
    style="anchor-name:--{{ $popoverAnchor }}"
    value="{{ $initialValue ? \Carbon\Carbon::parse($initialValue)->format('d.m.Y') : (old($popoverAnchor) ? \Carbon\Carbon::parse(old($popoverAnchor))->format('d.m.Y') : 'dd.mm.yyyy') }}">
    <span class="icon icon-sm icon-calendar me-1"></span>
    <span id="{{ $popoverAnchor }}_selected_date_text">
        {{ $initialValue ? \Carbon\Carbon::parse($initialValue)->format('d.m.Y') : (old($popoverAnchor) ? \Carbon\Carbon::parse(old($popoverAnchor))->format('d.m.Y') : 'dd.mm.yyyy') }}
    </span>
</button>

<div popover id="{{ $popoverTarget }}-popover" class="dropdown bg-base-100 rounded-box shadow-lg p-4"
    style="position-anchor:--{{ $popoverAnchor }}">
    <calendar-date class="cally" id="{{ $popoverAnchor }}_calendar_picker"
        data-initial-date="{{ $initialValue ?: old($popoverAnchor) }}">
        <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24">
            <path d="M15.75 19.5 8.25 12l7.5-7.5"></path>
        </svg>
        <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24">
            <path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
        </svg>
        <calendar-month></calendar-month>
    </calendar-date>
</div>