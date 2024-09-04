@props(['user'])

<x-layout title="Edit profile">
    <form method="POST" action="" class="space-y-2">
        @csrf
        @method('PUT')

        <x-forms.input label="Name" name="name" required value="{{ old('name', $user->name)}}" />
        <x-forms.divider />
        <x-forms.input label="E-mail" name="email" required value="{{ old('email', $user->email)}}"/>
        <x-forms.input label="Confirm E-mail" name="email_confirmation" required value="{{ old('email', $user->email)}}" />
        <x-forms.divider />
        <x-forms.input label="Update Password" name="password" type="password" />
        <x-forms.input label="Confirm New Password" name="password_confirmation" type="password" />

        <div class="flex justify-end align-center">
            <a href="{{ url('/') }}" class="mr-6 flex flex-row items-center">
                Cancel
            </a>
            <x-forms.button>
                Update Account
            </x-forms.button>
        </div>
    </form>
</x-layout>
