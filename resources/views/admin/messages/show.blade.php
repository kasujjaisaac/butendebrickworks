@extends('layouts.admin')

@section('admin-content')
    <div class="grid gap-6 xl:grid-cols-[1fr_320px]">
        {{-- Message body --}}
        <div class="space-y-6">
            {{-- Header card --}}
            <div class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Enquiry</p>
                        <h2 class="mt-2 font-display text-2xl font-semibold text-stone-950">{{ $message->subject }}</h2>
                    </div>
                    <span class="{{ $message->is_read ? 'border-stone-200 bg-stone-50 text-stone-500' : 'border-orange-200 bg-orange-50 text-[#b86033]' }} rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em]">
                        {{ $message->is_read ? 'Read' : 'Unread' }}
                    </span>
                </div>

                <dl class="mt-6 grid gap-3 text-sm sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">From</dt>
                        <dd class="mt-1 font-medium text-stone-900">{{ $message->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Email</dt>
                        <dd class="mt-1"><a href="mailto:{{ $message->email }}" class="text-[#b86033] hover:underline">{{ $message->email }}</a></dd>
                    </div>
                    @if ($message->phone)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Phone</dt>
                            <dd class="mt-1 text-stone-700">{{ $message->phone }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Received</dt>
                        <dd class="mt-1 text-stone-700">{{ $message->created_at->format('d M Y \a\t g:ia') }}</dd>
                    </div>
                    @if ($message->source_url)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Submitted from</dt>
                            <dd class="mt-1 truncate text-stone-500">{{ $message->source_url }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Message body --}}
            <div class="rounded-sm border border-[#d8c0ad] bg-white p-6 shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Message</p>
                <div class="prose prose-stone mt-4 max-w-none text-sm leading-7">
                    {!! nl2br(e($message->message)) !!}
                </div>
            </div>
        </div>

        {{-- Sidebar actions --}}
        <div class="space-y-4">
            {{-- Reply --}}
            <div class="rounded-sm border border-[#d8c0ad] bg-white p-5 shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#a25f38]">Quick Reply</p>
                <a
                    href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}"
                    class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-sm bg-[#b86033] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#cd6e3a]"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z"/></svg>
                    Reply via Email
                </a>
                @if ($message->phone)
                    <a
                        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}"
                        target="_blank"
                        rel="noreferrer"
                        class="mt-2 inline-flex w-full items-center justify-center gap-2 rounded-sm border border-[#d8c0ad] bg-white px-4 py-3 text-sm font-medium text-stone-700 transition hover:bg-[#fff7f0]"
                    >
                        <svg class="h-4 w-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        WhatsApp
                    </a>
                @endif
            </div>

            {{-- Delete --}}
            <div class="rounded-sm border border-rose-100 bg-white p-5 shadow-[0_8px_24px_rgba(0,0,0,0.05)]">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-stone-400">Danger Zone</p>
                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Permanently delete this enquiry?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-sm border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-medium text-rose-700 transition hover:bg-rose-100">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                        Delete Enquiry
                    </button>
                </form>
            </div>

            {{-- Back --}}
            <a href="{{ route('admin.messages.index') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-sm border border-[#d8c0ad] bg-white px-4 py-2.5 text-sm font-medium text-stone-600 transition hover:bg-[#fff7f0] hover:text-stone-900">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
                Back to Enquiries
            </a>
        </div>
    </div>
@endsection
