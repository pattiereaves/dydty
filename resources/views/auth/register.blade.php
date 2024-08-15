<x-layout>
    <h1>Register</h1>

    <x-forms.form method="POST" action="">
        <x-forms.input label="Name" name="name" />
        <x-forms.divider />
        <x-forms.input label="E-mail" name="email" />
        <x-forms.input label="Confirm E-mail" name="email_confirmation" />
        <x-forms.divider />
        <x-forms.input label="Password" name="password" type="password" />
        <x-forms.input label="Confirm Password" name="password_confirmation" />

        <div class="flex justify-end align-center">
            <a href="{{ url('/') }}" class="mr-6 flex flex-row items-center">
                Cancel
            </a>
            <x-forms.button>
                Create account
            </x-forms.button>
        </div>
    </x-forms.form>
</x-layout>
