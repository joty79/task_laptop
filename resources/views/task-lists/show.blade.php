<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-xl mx-auto">
            <div class="w-16">
                <!-- Empty div for spacing -->
            </div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center flex-1">
                {{ $taskList->title }}
            </h2>
            <div class="w-16 text-right">
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

            <!-- Search Box -->
            <div id="searchSection" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Search:</span>
                        <div class="relative flex-1">
                            <input 
                                type="text" 
                                id="taskSearch"
                                placeholder="Search tasks..."
                                class="w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ request('search') }}"
                                autocomplete="off"
                            >
                            <span 
                                id="suggestionText"
                                class="absolute text-sm text-gray-400 dark:text-gray-500 pointer-events-none top-0 h-full flex items-center"
                                style="left: calc(3px + 0.75rem + var(--suggestion-offset));"
                            ></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sort and Filter Options -->
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
                <div id="tasksWrapper" class="relative" style="min-height: auto;">
                    <div id="tasksContainer" class="divide-y divide-gray-200 dark:divide-gray-700">
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
                        @endforeach
                    </div>
                </div>
            </div>

            <script>
                let searchTimeout;
                let autocompleteTimeout;
                const tasksContainer = document.getElementById('tasksContainer');
                const tasksWrapper = document.getElementById('tasksWrapper');
                const searchInput = document.getElementById('taskSearch');
                const suggestionText = document.getElementById('suggestionText');
                const statusFilter = document.getElementById('status-filter');
                const sortBy = document.getElementById('sort-by');

                // Store initial height when page loads
                let fullHeight = tasksWrapper.offsetHeight;

                // Function to fetch and update tasks
                async function updateTasks() {
                    const searchQuery = encodeURIComponent(searchInput.value);
                    const status = statusFilter ? statusFilter.value : 'all';
                    const sort = sortBy ? sortBy.value : 'deadline';
                    
                    // Always maintain the full height during any update
                    tasksWrapper.style.minHeight = `${fullHeight}px`;
                    
                    try {
                        const response = await fetch(`{{ route('task-lists.show', $taskList) }}?search=${searchQuery}&status=${status}&sort=${sort}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const html = await response.text();
                        tasksContainer.innerHTML = html;
                        
                        // Only update fullHeight and reset minHeight when explicitly clearing search
                        if (!searchQuery && document.activeElement !== searchInput) {
                            tasksWrapper.style.minHeight = 'auto';
                            fullHeight = tasksWrapper.offsetHeight;
                        }
                    } catch (error) {
                        console.error('Error fetching tasks:', error);
                    }
                }

                // Add event listeners
                searchInput.addEventListener('input', (e) => {
                    clearTimeout(searchTimeout);
                    clearTimeout(autocompleteTimeout);
                    
                    // Clear previous suggestion immediately
                    suggestionText.textContent = '';
                    
                    // Show autocomplete after 1 second
                    autocompleteTimeout = setTimeout(() => {
                        showInlineAutocomplete(e.target.value);
                    }, 1000);
                    
                    // Update tasks after 300ms
                    searchTimeout = setTimeout(updateTasks, 300);
                });

                // Only reset height when search is explicitly cleared (e.g., by clicking X)
                searchInput.addEventListener('blur', () => {
                    if (!searchInput.value) {
                        setTimeout(() => {
                            tasksWrapper.style.minHeight = 'auto';
                            fullHeight = tasksWrapper.offsetHeight;
                        }, 100);
                    }
                });

                searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Tab' && suggestionText.textContent) {
                        e.preventDefault();
                        const currentInput = searchInput.value;
                        const suggestion = suggestionText.textContent;
                        searchInput.value = currentInput + suggestion;
                        suggestionText.textContent = '';
                        updateTasks();
                    }
                });

                if (statusFilter) {
                    statusFilter.addEventListener('change', updateTasks);
                }
                if (sortBy) {
                    sortBy.addEventListener('change', updateTasks);
                }

                // Add styles for smooth transitions
                tasksContainer.style.transition = 'height 0.3s ease-in-out';
                tasksContainer.style.overflow = 'hidden';
            </script>
        </div>
    </div>
</x-app-layout> 