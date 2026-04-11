{{-- Warning notice --}}
<div class="flex items-start gap-3 rounded-md border border-rose-200 bg-rose-50 px-4 py-4 mb-6">
    <svg class="mt-0.5 h-4 w-4 shrink-0 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
    </svg>
    <p class="text-xs text-rose-700 leading-relaxed">
        Once your account is deleted, all of its data — including orders, quotations and messages — will be <strong>permanently removed</strong> and cannot be recovered.
    </p>
</div>

<button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    class="inline-flex items-center gap-2 rounded-sm border border-rose-300 bg-white px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-600 hover:text-white hover:border-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
    </svg>
    Delete My Account
</button>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rose-100">
                <svg class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-[15px] font-semibold text-stone-900">Delete your account?</h2>
                <p class="text-xs text-stone-500 mt-0.5">This action cannot be undone.</p>
            </div>
        </div>

        <p class="text-sm text-stone-600 mb-5">
            Enter your password to confirm permanent deletion of your account and all associated data.
        </p>

        <div>
            <label for="delete_password" class="block text-[11px] font-semibold uppercase tracking-wide text-stone-500 mb-1.5">Your Password</label>
            <input id="delete_password" name="password" type="password" placeholder="••••••••"
                class="w-full rounded-md border border-stone-200 bg-stone-50 px-3 py-2 text-sm text-stone-900 placeholder-stone-300 outline-none transition focus:border-rose-500 focus:bg-white focus:ring-1 focus:ring-rose-500" />
            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5" />
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <button type="button" x-on:click="$dispatch('close')"
                class="rounded-sm border border-stone-200 bg-white px-4 py-2 text-sm font-semibold text-stone-700 transition hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-stone-300 focus:ring-offset-2">
                Cancel
            </button>
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-sm bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                </svg>
                Yes, Delete Account
            </button>
        </div>
    </form>
</x-modal>
