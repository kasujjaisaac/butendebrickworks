@php
    $honeypotField = config('monitoring.talk_to_us.honeypot_field', 'website');
    $honeypotId = $honeypotId ?? 'website-field';
@endphp

<div class="absolute -left-[9999px] top-auto h-px w-px overflow-hidden" aria-hidden="true">
    <label for="{{ $honeypotId }}">Leave this field empty</label>
    <input
        id="{{ $honeypotId }}"
        type="text"
        name="{{ $honeypotField }}"
        value=""
        tabindex="-1"
        autocomplete="off"
    >
</div>
