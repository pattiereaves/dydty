<x-layout>
    <h1>When {{ $task->name }} was done:</h1>
    <ol>
        @foreach ($task->histories as $record)
            <li>{{ $record->created_at->diffForHumans() }} by {{ $record->user->name === '' ? $record->user->email : $record->user->name }}</li>
        @endforeach
    </ol>
    <a href="/tasks">
        Back to all tasks
    </a>
</x-layout>
