@php
    $variant = $variant ?? 'dark';
    $panelClass = $panelClass ?? 'footer-panel';
    $isLight = $variant === 'light';

    $successClass = $isLight
        ? 'mb-5 border border-emerald-600 bg-emerald-50 px-4 py-3 text-sm text-emerald-700'
        : 'mb-5 border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200';
    $errorNoticeClass = $isLight
        ? 'mb-5 border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200'
        : 'mb-5 border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200';
    $labelClass    = $isLight ? 'form-label-dark' : 'form-label-dark';
    $errorClass    = $isLight ? 'form-error-dark' : 'form-error-dark';
    $inputClass    = $isLight ? 'outline-form-input' : 'footer-input';
    $textareaClass = $isLight ? 'outline-form-textarea' : 'footer-textarea';
@endphp

<div class="{{ $panelClass }}">
    @if (session('talk_to_us_success'))
        <div class="{{ $successClass }}">
            ✓ &nbsp;{{ session('talk_to_us_success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="{{ $errorNoticeClass }}">
            Please review the form and try again.
        </div>
    @endif

    <form method="POST" action="{{ route('talk-to-us.store') }}" class="grid gap-5">
        @csrf
        <input type="hidden" name="source_url" value="{{ url()->current() }}">

        {{-- Row 1: Name + Email --}}
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="talk-name" class="{{ $labelClass }}">Full name</label>
                <input id="talk-name" type="text" name="name" value="{{ old('name') }}"
                    class="{{ $inputClass }}"
                    placeholder="Your full name">
                @error('name')<p class="{{ $errorClass }}">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="talk-email" class="{{ $labelClass }}">Email address</label>
                <input id="talk-email" type="email" name="email" value="{{ old('email') }}"
                    class="{{ $inputClass }}"
                    placeholder="you@example.com">
                @error('email')<p class="{{ $errorClass }}">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Row 2: Phone + Subject --}}
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="talk-phone" class="{{ $labelClass }}">Phone number</label>
                <input id="talk-phone" type="text" name="phone" value="{{ old('phone') }}"
                    class="{{ $inputClass }}"
                    placeholder="+256...">
                @error('phone')<p class="{{ $errorClass }}">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="talk-subject" class="{{ $labelClass }}">Subject</label>
                <input id="talk-subject" type="text" name="subject" value="{{ old('subject') }}"
                    class="{{ $inputClass }}"
                    placeholder="Product enquiry">
                @error('subject')<p class="{{ $errorClass }}">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Message --}}
        <div>
            <label for="talk-message" class="{{ $labelClass }}">Message</label>
            <textarea id="talk-message" name="message"
                class="{{ $textareaClass }}"
                placeholder="Tell us what you are building, the products you need, or how we can help.">{{ old('message') }}</textarea>
            @error('message')<p class="{{ $errorClass }}">{{ $message }}</p>@enderror
        </div>

        {{-- Submit --}}
        <div>
            <button type="submit" class="cta-form-submit">
                Send Message
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true">
                    <path d="M3 12 21 3l-3 18-7-5-8 3 2-7Zm0 0 10-3"/>
                </svg>
            </button>
            <p style="margin-top:0.75rem;font-size:0.68rem;text-transform:uppercase;letter-spacing:0.18em;color:rgba(255,255,255,0.4);text-align:center;">Your information is stored securely</p>
        </div>
    </form>
</div>
