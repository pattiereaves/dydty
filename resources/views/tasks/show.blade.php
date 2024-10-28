<x-layout>
    <h1 class="mb-4">When <em>{{ $task->name }}</em> was done:</h1>
    <ol class="space-y-4">
        @foreach ($task->histories as $record)
            <li>{{ $record->created_at->diffForHumans() }} by {{ $record->user->name === '' ? $record->user->email : $record->user->name }}</li>
        @endforeach
    </ol>
    <a href="/tasks" class="mt-4 block">
        Back to all tasks
    </a>
</x-layout>
