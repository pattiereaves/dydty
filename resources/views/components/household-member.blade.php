@props(['user', 'householdId'])

@php
    $isSelf = Auth::user()->id === $user->id;
@endphp

@if (!$isSelf)
    <form action="{{ url('households/' . $householdId . '/leave') }}" method="POST" class="inline-flex align-middle">
        @csrf
        @method('POST')
        <input type="hidden" name="user_id" value="{{ $user->id }}" />
        <button>
            <span class="sr-only">
                Remove {{ $user->name === '' ? $user->email : $user->name }} from household
            </span>
            <span aria-hidden="">
                <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </span>
        </button>
    </form>
@endif

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

