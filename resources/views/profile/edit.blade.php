@extends('layouts.admin')

@section('pageTitle', 'My Profile')

@section('admin-content')
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Two-column row: Profile Info + Change Password --}}
        <div class="grid gap-6 lg:grid-cols-2 lg:items-start">

            <div class="border border-stone-200 bg-white shadow-sm rounded-md overflow-hidden">
                <div class="border-b border-stone-100 bg-stone-50 px-6 py-4">
                    <h2 class="text-[13px] font-semibold text-stone-800">Profile Information</h2>
                    <p class="text-[11px] text-stone-500 mt-0.5">Update your name, email, phone and organisation.</p>
                </div>
                <div class="px-6 py-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="border border-stone-200 bg-white shadow-sm rounded-md overflow-hidden">
                <div class="border-b border-stone-100 bg-stone-50 px-6 py-4">
                    <h2 class="text-[13px] font-semibold text-stone-800">Change Password</h2>
                    <p class="text-[11px] text-stone-500 mt-0.5">Ensure your account uses a strong, unique password.</p>
                </div>
                <div class="px-6 py-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>

        {{-- Full-width danger zone --}}
        <div class="border border-rose-200 bg-white shadow-sm rounded-md overflow-hidden">
            <div class="border-b border-rose-100 bg-rose-50 px-6 py-4">
                <h2 class="text-[13px] font-semibold text-rose-800">Danger Zone</h2>
                <p class="text-[11px] text-rose-400 mt-0.5">Permanently delete your account and all associated data.</p>
            </div>
            <div class="px-6 py-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
@endsection
