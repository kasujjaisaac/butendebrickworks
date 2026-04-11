<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — Butende Brick Works</title>
    <meta name="theme-color" content="#6e2f0e">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/butende-logo.jpg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#fdf8f5]"
      x-data="{ tab: '{{ $errors->any() && old('_form') === 'register' ? 'register' : 'login' }}' }"
      x-init="if (window.location.hash === '#register') tab = 'register'">

    {{-- Top bar --}}
    <div class="bg-[#6e2f0e]">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3">
            <a href="/" class="flex items-center">
                <span class="font-display text-sm font-semibold text-white">Butende Brick Works</span>
            </a>
            <a href="/" class="flex items-center gap-1.5 text-xs text-white/70 transition hover:text-white">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
                Back to site
            </a>
        </div>
    </div>

    {{-- Main --}}
    <div class="flex min-h-[calc(100vh-3rem)] flex-col items-center justify-center px-4 py-12">

        {{-- Card --}}
        <div class="w-full max-w-md">

            <div class="mb-6 text-center">
                <h1 class="font-display text-2xl font-semibold tracking-tight text-stone-900">Client Portal</h1>
                <p class="mt-1 text-sm text-stone-500">Track orders, manage quotations, and more.</p>
            </div>

            {{-- Tab toggle --}}
            <div class="mb-6 flex overflow-hidden rounded-sm border border-stone-200 bg-stone-100 p-1">
                <button type="button"
                    @click="tab = 'login'"
                    :class="tab === 'login' ? 'bg-[#6e2f0e] text-white shadow-sm' : 'text-stone-500 hover:text-stone-700'"
                    class="flex-1 rounded-[2px] py-2 text-sm font-semibold transition duration-150">
                    Sign In
                </button>
                <button type="button"
                    @click="tab = 'register'"
                    :class="tab === 'register' ? 'bg-[#6e2f0e] text-white shadow-sm' : 'text-stone-500 hover:text-stone-700'"
                    class="flex-1 rounded-[2px] py-2 text-sm font-semibold transition duration-150">
                    Sign Up
                </button>
            </div>

            {{-- Card body --}}
            <div class="rounded-sm border border-stone-200 bg-white shadow-sm">

                {{-- Session status --}}
                @if (session('status'))
                    <div class="border-b border-emerald-100 bg-emerald-50 px-6 py-3 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="border-b border-rose-100 bg-rose-50 px-6 py-3 text-sm font-medium text-rose-700">
                        Please review the highlighted fields and try again.
                    </div>
                @endif

                {{-- ===== SIGN IN FORM ===== --}}
                <div x-show="tab === 'login'" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-7">
                    <h2 class="font-display text-lg font-semibold text-stone-900">Welcome back</h2>
                    <p class="mt-1 text-sm text-stone-500">Sign in to your client account to continue.</p>

                    <form method="POST" action="{{ route('login') }}" class="mt-6 grid gap-5">
                        @csrf
                        <input type="hidden" name="_form" value="login">

                        <div>
                            <label for="login-email" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-stone-600">Email address</label>
                            <input id="login-email" type="email" name="email" value="{{ old('email') }}"
                                class="w-full rounded-sm border border-stone-300 bg-stone-50 px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 transition focus:border-[#b86033] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#b86033]/20 @error('email') border-rose-400 bg-rose-50 @enderror"
                                placeholder="you@example.com" required autofocus autocomplete="username">
                            @error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <div class="mb-1.5 flex items-center justify-between">
                                <label for="login-password" class="block text-xs font-semibold uppercase tracking-[0.12em] text-stone-600">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-[#b86033] transition hover:text-[#6e2f0e]">Forgot password?</a>
                                @endif
                            </div>
                            <input id="login-password" type="password" name="password"
                                class="w-full rounded-sm border border-stone-300 bg-stone-50 px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 transition focus:border-[#b86033] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#b86033]/20 @error('password') border-rose-400 bg-rose-50 @enderror"
                                placeholder="••••••••" required autocomplete="current-password">
                            @error('password')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex items-center gap-2">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="h-4 w-4 rounded-sm border-stone-300 text-[#b86033] focus:ring-[#b86033]/30">
                            <label for="remember_me" class="text-sm text-stone-600">Keep me signed in</label>
                        </div>

                        <button type="submit"
                            class="mt-1 flex w-full items-center justify-center gap-2 rounded-sm bg-[#6e2f0e] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#5a2509] focus:outline-none focus:ring-2 focus:ring-[#6e2f0e]/40">
                            Sign In
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        </button>
                    </form>

                    <p class="mt-5 text-center text-sm text-stone-500">
                        Don't have an account?
                        <button type="button" @click="tab = 'register'" class="font-semibold text-[#b86033] transition hover:text-[#6e2f0e]">Sign up</button>
                    </p>
                </div>

                {{-- ===== SIGN UP FORM ===== --}}
                <div x-show="tab === 'register'" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-7">
                    <h2 class="font-display text-lg font-semibold text-stone-900">Create your account</h2>
                    <p class="mt-1 text-sm text-stone-500">Register to track orders and manage quotations.</p>

                    <form method="POST" action="{{ route('register') }}" class="mt-6 grid gap-5">
                        @csrf
                        <input type="hidden" name="_form" value="register">

                        <div>
                            <label for="reg-name" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-stone-600">Full name</label>
                            <input id="reg-name" type="text" name="name" value="{{ old('name') }}"
                                class="w-full rounded-sm border border-stone-300 bg-stone-50 px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 transition focus:border-[#b86033] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#b86033]/20 @error('name') border-rose-400 bg-rose-50 @enderror"
                                placeholder="Your full name" required autofocus autocomplete="name">
                            @error('name')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="reg-email" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-stone-600">Email address</label>
                            <input id="reg-email" type="email" name="email" value="{{ old('email') }}"
                                class="w-full rounded-sm border border-stone-300 bg-stone-50 px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 transition focus:border-[#b86033] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#b86033]/20 @error('email') border-rose-400 bg-rose-50 @enderror"
                                placeholder="you@example.com" required autocomplete="username">
                            @error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="reg-phone" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-stone-600">
                                    Phone <span class="font-normal normal-case tracking-normal text-stone-400">(optional)</span>
                                </label>
                                <input id="reg-phone" type="text" name="phone" value="{{ old('phone') }}"
                                    class="w-full rounded-sm border border-stone-300 bg-stone-50 px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 transition focus:border-[#b86033] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#b86033]/20 @error('phone') border-rose-400 bg-rose-50 @enderror"
                                    placeholder="+256 ..." autocomplete="tel">
                                @error('phone')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="reg-organisation" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-stone-600">
                                    Organisation <span class="font-normal normal-case tracking-normal text-stone-400">(optional)</span>
                                </label>
                                <input id="reg-organisation" type="text" name="organisation" value="{{ old('organisation') }}"
                                    class="w-full rounded-sm border border-stone-300 bg-stone-50 px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 transition focus:border-[#b86033] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#b86033]/20 @error('organisation') border-rose-400 bg-rose-50 @enderror"
                                    placeholder="Company / Institution" autocomplete="organization">
                                @error('organisation')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="reg-password" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-stone-600">Password</label>
                                <input id="reg-password" type="password" name="password"
                                    class="w-full rounded-sm border border-stone-300 bg-stone-50 px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 transition focus:border-[#b86033] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#b86033]/20 @error('password') border-rose-400 bg-rose-50 @enderror"
                                    placeholder="••••••••" required autocomplete="new-password">
                                @error('password')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="reg-password-confirm" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-stone-600">Confirm password</label>
                                <input id="reg-password-confirm" type="password" name="password_confirmation"
                                    class="w-full rounded-sm border border-stone-300 bg-stone-50 px-4 py-2.5 text-sm text-stone-900 placeholder-stone-400 transition focus:border-[#b86033] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#b86033]/20"
                                    placeholder="••••••••" required autocomplete="new-password">
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-1 flex w-full items-center justify-center gap-2 rounded-sm bg-[#6e2f0e] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#5a2509] focus:outline-none focus:ring-2 focus:ring-[#6e2f0e]/40">
                            Create Account
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        </button>
                    </form>

                    <p class="mt-5 text-center text-sm text-stone-500">
                        Already have an account?
                        <button type="button" @click="tab = 'login'" class="font-semibold text-[#b86033] transition hover:text-[#6e2f0e]">Sign in</button>
                    </p>
                </div>

            </div>

            {{-- Footer note --}}
            <p class="mt-5 text-center text-[0.65rem] font-medium uppercase tracking-widest text-stone-400">
                Butende Brick Works &mdash; Diocese of Masaka &mdash; Since 1967
            </p>
        </div>
    </div>

</body>
</html>

