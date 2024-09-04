@props(['token'])

<x-layout title="Reset password">
    <x-forms.form method="POST" action="{{ url('/reset-password') }}">
        <x-forms.input label="Email" name="email" value="{{ request('email') }}" />
        <x-forms.input label="New Password" name="password" type="password" />
        <x-forms.input label="Confirm New Password" name="password_confirmation" type="password" />
        <input type="hidden" name="token" value="{{ $token }}"/>

        <x-forms.button>
            Update password
        </x-forms.button>
    </x-forms.form>
</x-layout>
