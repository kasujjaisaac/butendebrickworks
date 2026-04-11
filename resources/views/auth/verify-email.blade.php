<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email — Butende Brick Works</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-[#fdf8f5] font-sans text-stone-900 antialiased">

    {{-- Top bar --}}
    <header class="border-b border-stone-200 bg-white">
        <div class="mx-auto flex h-14 max-w-6xl items-center px-6">
            <a href="{{ url('/') }}" class="text-base font-bold tracking-tight text-[#6e2f0e]">Butende Brick Works</a>
        </div>
    </header>

    {{-- Main --}}
    <main class="flex min-h-[calc(100vh-56px)] items-center justify-center px-4 py-16">
        <div class="w-full max-w-md">

            {{-- Card --}}
            <div class="rounded bg-white px-8 py-10 shadow-sm ring-1 ring-stone-200">

                {{-- Icon --}}
                <div class="mb-6 flex justify-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#6e2f0e]/10">
                        <svg class="h-7 w-7 text-[#6e2f0e]" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                        </svg>
                    </div>
                </div>

                <h1 class="mb-2 text-center text-xl font-bold text-stone-900">Verify your email</h1>
                <p class="mb-6 text-center text-sm leading-6 text-stone-500">
                    We sent a verification link to your email address. Click the link in that email to activate your account.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-5 rounded-sm bg-emerald-50 px-4 py-3 text-center text-sm text-emerald-700 ring-1 ring-emerald-200">
                        A new verification link has been sent to your email.
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-sm bg-[#6e2f0e] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#5a2509] focus:outline-none focus:ring-2 focus:ring-[#6e2f0e]/40">
                        Resend verification email
                    </button>
                </form>

                <div class="mt-5 text-center">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-stone-400 transition hover:text-stone-700">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
