<x-layout>
    <h1>Task history for {{ $task->name }}</h1>
    <ol>
        @foreach ($task->histories as $record)
            <li>{{ $record->created_at }} by {{ $record->user->name }}</li>
        @endforeach
    </ol>
    <a href="/tasks">
        Back to all tasks
    </a>
</x-layout>
