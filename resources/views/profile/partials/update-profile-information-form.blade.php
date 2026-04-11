{{-- Hidden verification form --}}
<form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

{{-- Avatar strip --}}
<div class="flex items-center gap-4 pb-6 mb-6 border-b border-stone-100">
    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#6e2f0e] text-white font-bold text-xl select-none">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>
    <div>
        <p class="text-sm font-semibold text-stone-900">{{ $user->name }}</p>
        <p class="text-xs text-stone-400">{{ $user->email }}</p>
        <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.15em] text-stone-300">Member since {{ $user->created_at->format('M Y') }}</p>
    </div>
</div>

<form method="post" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('patch')

    {{-- Name --}}
    <div>
        <label for="name" class="block text-[11px] font-semibold uppercase tracking-wide text-stone-500 mb-1.5">Full Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
            class="w-full rounded-md border border-stone-200 bg-stone-50 px-3 py-2 text-sm text-stone-900 placeholder-stone-300 outline-none transition focus:border-[#6e2f0e] focus:bg-white focus:ring-1 focus:ring-[#6e2f0e]" />
        <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
    </div>

    {{-- Email --}}
    <div>
        <label for="email" class="block text-[11px] font-semibold uppercase tracking-wide text-stone-500 mb-1.5">Email Address</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
            class="w-full rounded-md border border-stone-200 bg-stone-50 px-3 py-2 text-sm text-stone-900 placeholder-stone-300 outline-none transition focus:border-[#6e2f0e] focus:bg-white focus:ring-1 focus:ring-[#6e2f0e]" />
        <x-input-error class="mt-1.5" :messages="$errors->get('email')" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2 flex items-center gap-2 rounded-md border border-amber-200 bg-amber-50 px-3 py-2">
                <svg class="h-4 w-4 shrink-0 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
                </svg>
                <p class="text-xs text-amber-700">
                    Email not verified.
                    <button form="send-verification" class="font-semibold underline hover:text-amber-900">Resend verification</button>
                </p>
            </div>
            @if (session('status') === 'verification-link-sent')
                <p class="mt-1.5 text-xs font-medium text-green-600">Verification link sent to your email.</p>
            @endif
        @endif
    </div>

    {{-- Phone + Organisation --}}
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="phone" class="block text-[11px] font-semibold uppercase tracking-wide text-stone-500 mb-1.5">Phone Number</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" autocomplete="tel" placeholder="+256 7XX XXX XXX"
                class="w-full rounded-md border border-stone-200 bg-stone-50 px-3 py-2 text-sm text-stone-900 placeholder-stone-300 outline-none transition focus:border-[#6e2f0e] focus:bg-white focus:ring-1 focus:ring-[#6e2f0e]" />
            <x-input-error class="mt-1.5" :messages="$errors->get('phone')" />
        </div>
        <div>
            <label for="organisation" class="block text-[11px] font-semibold uppercase tracking-wide text-stone-500 mb-1.5">Organisation / Company</label>
            <input id="organisation" name="organisation" type="text" value="{{ old('organisation', $user->organisation) }}" placeholder="Your company name"
                class="w-full rounded-md border border-stone-200 bg-stone-50 px-3 py-2 text-sm text-stone-900 placeholder-stone-300 outline-none transition focus:border-[#6e2f0e] focus:bg-white focus:ring-1 focus:ring-[#6e2f0e]" />
            <x-input-error class="mt-1.5" :messages="$errors->get('organisation')" />
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-3 pt-1">
        <button type="submit"
            class="inline-flex items-center gap-2 rounded-sm bg-[#6e2f0e] px-5 py-2 text-sm font-semibold text-white transition hover:bg-[#5a2609] focus:outline-none focus:ring-2 focus:ring-[#6e2f0e] focus:ring-offset-2">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            Save Changes
        </button>

        @if (session('status') === 'profile-updated')
            <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)"
                class="inline-flex items-center gap-1.5 rounded-sm bg-green-50 border border-green-200 px-3 py-1.5 text-xs font-semibold text-green-700">
                <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Saved
            </span>
        @endif
    </div>
</form>
