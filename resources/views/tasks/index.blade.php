<x-layout>
    @foreach ($user->households as $household)
        <h2 class="text-lg font-bold border-b-2 mb-2">{{ $household->name }} household tasks</h2>

        <ul>
            @foreach ($household->tasks as $task)
                <li>{{ $task->name }}</li>
            @endforeach
        </ul>
    @endforeach
</x-layout>
