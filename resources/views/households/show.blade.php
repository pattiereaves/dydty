<x-layout>
    <h1>Household: {{ $household->name}} members</h1>

    <ul>
        @foreach ($household->users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>

    @if($household->users->contains(Auth::user()))
        <x-forms.form method="POST" action="{{ url('/households/'.$household->id.'/leave') }}">
            <x-forms.button>
                Leave this household
            </x-forms.button>
        </x-forms.form>
        @else
        <x-forms.form method="POST" action="{{ url('/households/'.$household->id.'/join') }}">
            <x-forms.button>
                Join this household
            </x-forms.button>
        </x-forms.form>
    @endif

    <a href="{{ url('households') }}">Back to list of households</a>
    <span class="px-2">
        |
    </span>
    <a href="{{ url('/tasks') }}">
        Back to all tasks
    </a>
</x-layout>
