<x-layout>
    @foreach ($user->households as $household)
        <h2 class="text-lg font-bold border-b-2 mb-2">{{ $household->name }} household tasks</h2>

        <ul>
            @foreach ($household->tasks as $task)
                <li class="flex flex-wrap items-center justify-start mb-3">
                    <x-forms.taskCheck :$task class="mr-4 grow-1 w-full mb-1" />
                    <div class="grow-1 w-full">
                        <span>
                            Every <strong>{{ $task->human_readable_completion_interval }}</strong>
                        </span>
                        |
                        <span>
                            Last completed: {{ $task->last_completed }}
                        </span>
                        <a href="{{ url('task/'.$task->id) }}" class="text-sm flex grow-1 w-full">View history</a>
                    </div>
                </li>
            @endforeach
        </ul>

        <a href="{{ url('/households/'.$household->id.'/task/add') }}">Add a task</a>
    @endforeach
</x-layout>
