<form method="post" action="{{ route('password.update') }}" class="space-y-5" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
    @csrf
    @method('put')

    {{-- Current Password --}}
    <div>
        <label for="update_password_current_password" class="block text-[11px] font-semibold uppercase tracking-wide text-stone-500 mb-1.5">Current Password</label>
        <div class="relative">
            <input id="update_password_current_password" name="current_password"
                :type="showCurrent ? 'text' : 'password'"
                autocomplete="current-password"
                class="w-full rounded-md border border-stone-200 bg-stone-50 px-3 py-2 pr-10 text-sm text-stone-900 placeholder-stone-300 outline-none transition focus:border-[#6e2f0e] focus:bg-white focus:ring-1 focus:ring-[#6e2f0e]" />
            <button type="button" @click="showCurrent = !showCurrent"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 focus:outline-none">
                <svg x-show="!showCurrent" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <svg x-show="showCurrent" x-cloak class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                </svg>
            </button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5" />
    </div>

    {{-- New Password --}}
    <div>
        <label for="update_password_password" class="block text-[11px] font-semibold uppercase tracking-wide text-stone-500 mb-1.5">New Password</label>
        <div class="relative">
            <input id="update_password_password" name="password"
                :type="showNew ? 'text' : 'password'"
                autocomplete="new-password"
                class="w-full rounded-md border border-stone-200 bg-stone-50 px-3 py-2 pr-10 text-sm text-stone-900 placeholder-stone-300 outline-none transition focus:border-[#6e2f0e] focus:bg-white focus:ring-1 focus:ring-[#6e2f0e]" />
            <button type="button" @click="showNew = !showNew"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 focus:outline-none">
                <svg x-show="!showNew" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <svg x-show="showNew" x-cloak class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                </svg>
            </button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5" />
    </div>

    {{-- Confirm Password --}}
    <div>
        <label for="update_password_password_confirmation" class="block text-[11px] font-semibold uppercase tracking-wide text-stone-500 mb-1.5">Confirm New Password</label>
        <div class="relative">
            <input id="update_password_password_confirmation" name="password_confirmation"
                :type="showConfirm ? 'text' : 'password'"
                autocomplete="new-password"
                class="w-full rounded-md border border-stone-200 bg-stone-50 px-3 py-2 pr-10 text-sm text-stone-900 placeholder-stone-300 outline-none transition focus:border-[#6e2f0e] focus:bg-white focus:ring-1 focus:ring-[#6e2f0e]" />
            <button type="button" @click="showConfirm = !showConfirm"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 focus:outline-none">
                <svg x-show="!showConfirm" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <svg x-show="showConfirm" x-cloak class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                </svg>
            </button>
        </div>
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5" />
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-3 pt-1">
        <button type="submit"
            class="inline-flex items-center gap-2 rounded-sm bg-[#6e2f0e] px-5 py-2 text-sm font-semibold text-white transition hover:bg-[#5a2609] focus:outline-none focus:ring-2 focus:ring-[#6e2f0e] focus:ring-offset-2">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
            </svg>
            Update Password
        </button>

        @if (session('status') === 'password-updated')
            <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)"
                class="inline-flex items-center gap-1.5 rounded-sm bg-green-50 border border-green-200 px-3 py-1.5 text-xs font-semibold text-green-700">
                <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Updated
            </span>
        @endif
    </div>
</form>
