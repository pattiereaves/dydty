<x-layout title="{{ $household->name }} household">
    @if($household->users->contains(Auth::user()))
        <form method="POST" action="{{ url('/households/'.$household->id.'/leave') }}">
            @csrf
            @method('POST')
            <button class="p-2 rounded bg-black/10 mb-5">
                Leave this household
            </button>
        </form>
        @else
        <form method="POST" action="{{ url('/households/'.$household->id.'/join') }}">
            @csrf
            @method('POST')
            <button class="p-2 rounded bg-black/10 mb-5">
                Join this household
            </button>
        </form>
    @endif

    <ul class="mb-5">
        @foreach ($household->users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>

    <a href="{{ url('households') }}">Back to list of households</a>
    <span class="px-2">
        |
    </span>
    <a href="{{ url('/tasks') }}">
        Back to all tasks
    </a>
</x-layout>
