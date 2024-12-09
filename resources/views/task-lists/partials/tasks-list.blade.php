<!-- Tasks List Partial -->
<div class="tasks-list">
    @foreach($tasks as $task)
        <div class="task-item divide-y divide-gray-200 dark:divide-gray-700" data-task-id="{{ $task->id }}">
            <div class="p-4 flex items-center gap-4">
                <div class="drag-handle cursor-move text-gray-400 hover:text-gray-600 dark:text-gray-600 dark:hover:text-gray-400">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <circle cx="7" cy="5" r="1.5"/>
                        <circle cx="13" cy="5" r="1.5"/>
                        <circle cx="7" cy="10" r="1.5"/>
                        <circle cx="13" cy="10" r="1.5"/>
                        <circle cx="7" cy="15" r="1.5"/>
                        <circle cx="13" cy="15" r="1.5"/>
                    </svg>
                </div>
                <form action="{{ route('tasks.toggle-complete', $task) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-2xl">
                        @if($task->is_completed)
                            ✓
                        @else
                            ○
                        @endif
                    </button>
                </form>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div class="{{ $task->is_completed ? 'line-through text-gray-500 dark:text-gray-500' : 'text-gray-800 dark:text-gray-200' }}">
                            <div class="font-medium">{{ $task->title }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Priority: {{ ucfirst($task->priority) }}
                                @if($task->deadline)
                                    | Due: {{ $task->deadline->format('M d, Y') }}
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @include('task-lists.partials.task-actions', ['task' => $task])
                        </div>
                    </div>
                    @if($task->deadline)
                        <div class="mt-2">
                            <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mb-1">
                                <span>{{ $task->created_at->format('M d, Y') }}</span>
                                <span>{{ $task->getTimeStatus() }}</span>
                                <span>{{ $task->deadline->format('M d, Y') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 relative">
                                @if($task->is_completed)
                                    <div class="absolute h-1.5 rounded-full bg-green-600 left-0 top-0" style="width: 100%"></div>
                                @else
                                    <?php 
                                        $elapsedWidth = $task->getElapsedPercentage();
                                        $remainingWidth = 100 - $elapsedWidth;
                                    ?>
                                    <div class="absolute h-1.5 rounded-l-full bg-red-600 left-0 top-0" style="width: <?php echo $elapsedWidth; ?>%"></div>
                                    <div class="absolute h-1.5 rounded-r-full bg-blue-600 top-0" style="left: <?php echo $elapsedWidth; ?>%; width: <?php echo $remainingWidth; ?>%"></div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div> 