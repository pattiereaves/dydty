<x-layout>
    A way for a household to communicate if a repeated task is done.

    @auth
        You are logged in, {{ Auth::user()->name }}! <a href="{{ url('/tasks') }}">View your tasks.</a>
    @endauth

    @guest
        Would you like to <a href="{{ url('/register') }}">register</a> or <a href="{{ url('/login') }}">login</a>?
    @endguest
</x-layout>
