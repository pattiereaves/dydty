@php
    $options = [
        'Twice a day' => 12 * 60 * 60,
        'Daily' => 24 * 60 * 60,
        'Semi-weekly' => 3.5 * 24 * 60 * 60,
        'Weekly' => 7 * 24 * 60 * 60,
        'Fortnightly' => 14 * 24 * 60 * 60,
        'Monthly' => 30 * 24 * 60 * 60,
        'Quarterly' => 90 * 24 * 60 * 60,
        'Semi-annually' => 180 * 24 * 60 * 60,
        'Annually' => 365 * 24 * 60 * 60,
];
@endphp

<x-layout>
    <h1>Add a task to {{ $household->name }}</h1>

    <x-forms.form method="POST" action="">
        <input type="hidden" name="household_id" value="{{ $household->id }}" />
        <x-forms.input label="Task description" name="name" required />
        <x-forms.select label="How often should this task be completed?" name="completion_interval" required>
            @foreach ($options as $label => $value)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </x-forms.select>

        <a href="{{ url("tasks" ) }}">
            Cancel
        </a>
        <x-forms.button>
            Create
        </x-forms.button>
    </x-forms.form>
</x-layout>
