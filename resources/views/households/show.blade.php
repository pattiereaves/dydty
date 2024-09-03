@php
    $isMember = $household->users->contains(Auth::user());
@endphp
<x-layout title="{{ $household->name }} household">
    @if($isMember)
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
            <li>
                {{ $user->name ?? $user->email }}
                @if ($user->name === '')
                    <span class="text-slate-500">
                        {{ $user->email }}
                    </span>
                @endif

                @if ($user->pivot->invitation_pending)
                <span class="text-slate-500">
                    (pending)
                </span>
                @endif
            </li>
        @endforeach
    </ul>

    @if ($isMember)
        <div>
            <button onClick="(function (e) { e.target.className = 'hidden'; document.getElementById('add-member-form').classList.remove('hidden')})(arguments[0])">
                Add household member
            </button>
            <form method="POST" action="{{ url('/households/'.$household->id.'/invite')}}" id="add-member-form" class="space-y-2 mb-10 hidden">
                @csrf
                @method('POST')
                <x-forms.input type="text" name="email" label="Email" class="md:w-1/2"/>
                <x-forms.button>
                    Invite member to this household
                </x-forms.button>
            </form>
        </div>
    @endif

    <a href="{{ url('households') }}">Back to list of households</a>
    <span class="px-2">
        |
    </span>
    <a href="{{ url('/tasks') }}">
        Back to all tasks
    </a>
</x-layout>
