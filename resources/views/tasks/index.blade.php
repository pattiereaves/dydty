<x-layout title="All Tasks">
    @if ($user->households->count() === 0)
        <section class="space-y-2">
            <h2 class="text-lg">
                You don't belong to any households.
            </h2>

            <p>
                There are two options:
            </p>

            <ol class="list-decimal list-inside">
                <li><a href="{{ url('/households/add') }}">Create a new household.</a></li>
                <li>Ask a member of an existing household to add you.</li>
            </ol>
        </section>
    @endif

    <ul class="space-y-10">
        @foreach ($households as $household)
            <li class="space-y-4 space-y-reverse">
                @if ($household->pivot->invitation_pending)
                    <form class="inline-flex" method="POST" action="{{ url('/households/' . $household->id . '/join') }}">
                        @csrf
                        @method('POST')

                        <button class="bg-blue rounded-xl p-2 text-white">
                            📥 Accept invitation to {{ $household->name }}
                        </button>
                    </form>
                    <form class="inline-flex" method="POST" action="{{ url('/households/' . $household->id . '/leave') }}">
                        @csrf
                        @method('POST')

                        <button>
                            Decline
                        </button>
                    </form>
                @else
                    <h2 class="text-lg font-bold border-b-2 mb-2">
                        {{ $household->name }} household tasks
                        <a href="{{ url('households/' . $household->id) }}"
                            class="w-1 h-1 text-xs rounded-lg bg-black/10 border-blue p-1">
                            <span class="sr-only">View all members</span>
                            🧑‍🤝‍🧑
                        </a>
                    </h2>
                    <ul class="space-y-4">
                        @foreach ($household->tasks as $task)
                            @if (!$task->is_active)
                                @continue
                            @endif

                            <li class="flex flex-wrap items-center justify-start mb-3 space-y-2">
                                <x-forms.taskCheck :$task class="mr-4 grow-1 w-full mb-1" />
                                <div class="grow-1 w-full space-y-1">
                                    <span>
                                        Every <strong>{{ $task->human_readable_completion_interval }}</strong>
                                    </span>
                                    |
                                    <span>
                                        Last completed: {{ $task->last_completed }}
                                        @if ($task->last_completed !== 'Never')
                                            by {{ $task->last_completed_by }}
                                        @endif
                                    </span>
                                    <div class="text-sm flex grow-1 w-full">
                                        <a href="{{ url('task/' . $task->id) }}" class="">View history</a>
                                        <span class="mx-1">|</span>
                                        <form method="POST" action="{{ url('task/' . $task->id . '/archive') }}">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="task_id" value="{{ $task->id }}" />
                                            <button class="inline">
                                                Archive this task
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ url('/households/' . $household->id . '/task/add') }}">Add a task</a>
                @endif
            </li>
        @endforeach
    </ul>
</x-layout>
