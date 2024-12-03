<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-xl mx-auto">
            <div class="w-16">
                <!-- Empty div for spacing -->
            </div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center flex-1">
                {{ $taskList->title }}
            </h2>
            <div class="w-16 text-right flex items-center justify-end space-x-4">
                <a href="{{ route('task-lists.edit', $taskList) }}" 
                   class="text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                </a>
                <a href="{{ route('task-lists.index') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                    ← Back
                </a>
            </div>
        </div>
    </x-slot>

    @if($taskList->description)
        <div class="py-4">
            <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-800 dark:text-gray-200">
                        {{ $taskList->description }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Create New Task Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <form action="{{ route('tasks.store', $taskList) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="title" value="Task Title" class="dark:text-gray-300" />
                                <x-text-input 
                                    id="title" 
                                    name="title" 
                                    type="text" 
                                    class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300" 
                                    required 
                                    value="{{ old('title') }}"
                                />
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-input-label for="priority" value="Priority" class="dark:text-gray-300" />
                                <select 
                                    name="priority" 
                                    id="priority" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm">
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('priority')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-input-label for="deadline" value="Deadline" class="dark:text-gray-300" />
                                <x-text-input 
                                    id="deadline" 
                                    name="deadline" 
                                    type="date" 
                                    class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300" 
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('deadline') }}"
                                    required
                                />
                                @error('deadline')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-primary-button class="w-full justify-center">
                                    Add Task
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add this before the sort and filter options -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Search:</span>
                        <input 
                            type="text" 
                            id="taskSearch"
                            placeholder="Search tasks..."
                            class="flex-1 text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            value="{{ request('search') }}"
                        >
                    </div>
                </div>
            </div>

            <!-- Add this before the Tasks List section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <!-- Sort Options -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Sort by:</span>
                            <select 
                                onchange="window.location.href = this.value"
                                class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="{{ route('task-lists.show', ['taskList' => $taskList, 'sort' => 'deadline', 'status' => request('status')]) }}" 
                                        {{ request('sort', 'deadline') === 'deadline' ? 'selected' : '' }}>
                                    Deadline
                                </option>
                                <option value="{{ route('task-lists.show', ['taskList' => $taskList, 'sort' => 'priority', 'status' => request('status')]) }}"
                                        {{ request('sort') === 'priority' ? 'selected' : '' }}>
                                    Priority
                                </option>
                                <option value="{{ route('task-lists.show', ['taskList' => $taskList, 'sort' => 'completion', 'status' => request('status')]) }}"
                                        {{ request('sort') === 'completion' ? 'selected' : '' }}>
                                    Completion
                                </option>
                            </select>
                        </div>

                        <!-- Filter Options -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Show:</span>
                            <select 
                                onchange="window.location.href = this.value"
                                class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="{{ route('task-lists.show', ['taskList' => $taskList, 'sort' => request('sort'), 'status' => 'all']) }}"
                                        {{ !request('status') || request('status') === 'all' ? 'selected' : '' }}>
                                    All Tasks
                                </option>
                                <option value="{{ route('task-lists.show', ['taskList' => $taskList, 'sort' => request('sort'), 'status' => 'pending']) }}"
                                        {{ request('status') === 'pending' ? 'selected' : '' }}>
                                    Pending Only
                                </option>
                                <option value="{{ route('task-lists.show', ['taskList' => $taskList, 'sort' => request('sort'), 'status' => 'completed']) }}"
                                        {{ request('status') === 'completed' ? 'selected' : '' }}>
                                    Completed Only
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($tasks as $task)
                        <div class="p-4 flex items-center gap-4">
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
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this task?')"
                                                class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
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
                                                <div class="absolute h-1.5 rounded-full bg-green-600 left-0 top-0" 
                                                     @style(['width' => '100%'])>
                                                </div>
                                            @else
                                                <div class="absolute h-1.5 rounded-l-full bg-red-600 left-0 top-0" 
                                                     @style(['width' => $task->getElapsedPercentage() . '%'])>
                                                </div>
                                                <div class="absolute h-1.5 rounded-r-full bg-blue-600 top-0" 
                                                     @style([
                                                         'left' => $task->getElapsedPercentage() . '%',
                                                         'width' => (100 - $task->getElapsedPercentage()) . '%'
                                                     ])>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 

<!-- Add this JavaScript at the bottom of the file -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('taskSearch');
    let debounceTimer;

    // Focus the search input if it has a value
    if (searchInput.value) {
        searchInput.focus();
        // Place cursor at the end of the text
        const length = searchInput.value.length;
        searchInput.setSelectionRange(length, length);
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const currentUrl = new URL(window.location.href);
            const searchValue = this.value.trim();
            
            if (searchValue) {
                currentUrl.searchParams.set('search', searchValue);
            } else {
                currentUrl.searchParams.delete('search');
            }

            // Preserve other parameters
            const status = currentUrl.searchParams.get('status');
            const sort = currentUrl.searchParams.get('sort');
            if (status) currentUrl.searchParams.set('status', status);
            if (sort) currentUrl.searchParams.set('sort', sort);

            window.location.href = currentUrl.toString();
        }, 300); // 300ms debounce delay
    });
});
</script> 