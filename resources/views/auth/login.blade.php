<x-layout>
    <h1 class="text-lg">Login</h1>

    <x-forms.form method="POST" action="{{ url('/login') }}">
        <x-forms.input name="email" label="E-mail" type="email" required />
        <x-forms.input name="password" label="Password" type="password" required />
        <div class="flex flex-row justify-end items-center">
            <a href="{{ url('/') }}" class="mr-6">
                Cancel
            </a>
            <a href="{{ url('/register') }}" class="mr-6">
                Register
            </a>
            <x-forms.button>
                Login
            </x-forms.button>
        </div>
    </x-forms.form>
</x-layout>
