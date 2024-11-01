@php
    $isMember = $household->users->contains(Auth::user());
@endphp
<x-layout>
    <x-slot name="title">
        @if ($isMember)
        <div>
            <form method="POST" action="{{ url('/households/' . $household->id . '/edit')}}">
                @method('PUT')
                @csrf
                <input
                    type="text"
                    name="name"
                    label="Household name"
                    value="{{ $household->name }}"
                    onchange="this.form.elements.namedItem('name-form').classList.remove('hidden')"
                />
                <x-forms.button id="name-form" class="tracking-wide text-xs font-thin hidden">
                    Save
                </x-forms.button>
            </form>
        </div>
        @else
            {{ $household->name }} household
        @endif
    </x-slot>

    @if ($errors->any())
        <div class="text-red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($isMember)
        <form method="POST" action="{{ url('/households/' . $household->id . '/leave') }}">
            @csrf
            @method('POST')
            <button class="p-2 rounded bg-black/10 mb-5">
                Leave this household
            </button>
        </form>
    @else
        <form method="POST" action="{{ url('/households/' . $household->id . '/join') }}">
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
                <x-household-member :user="$user" :household="$household" />
            </li>
        @endforeach
    </ul>

    @if ($isMember)
        <div>
            <button
                onClick="(function (e) { e.target.className = 'hidden'; document.getElementById('add-member-form').classList.remove('hidden')})(arguments[0])">
                Add household member
            </button>
            <form method="POST" action="{{ url('/households/' . $household->id . '/invite') }}" id="add-member-form"
                class="space-y-2 mb-10 hidden">
                @csrf
                @method('POST')
                <x-forms.input type="text" name="email" label="Email" class="md:w-1/2" />
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
