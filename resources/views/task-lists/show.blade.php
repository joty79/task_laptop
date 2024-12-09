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
                                <option value="{{ route('task-lists.show', ['taskList' => $taskList, 'sort' => 'custom', 'status' => request('status')]) }}"
                                        {{ request('sort') === 'custom' ? 'selected' : '' }}>
                                    Custom
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
                        @include('task-lists.partials.tasks-list', ['tasks' => $tasks])
                    </div>
                </div>
            </div>

            <script>
                const tasksContainer = document.querySelector('.tasks-list');
                const searchInput = document.getElementById('taskSearch');
                const statusFilter = document.getElementById('status-filter');
                const sortBy = document.querySelector('select[onchange*="sort"]');
                let sortableInstance = null;

                // Initialize Sortable
                function initSortable() {
                    if (sortableInstance) {
                        sortableInstance.destroy();
                    }

                    const currentSort = new URL(window.location.href).searchParams.get('sort');
                    if (currentSort === 'custom' && tasksContainer) {
                        sortableInstance = Sortable.create(tasksContainer, {
                            handle: '.drag-handle',
                            animation: 150,
                            draggable: '.task-item',
                            onEnd: async function(evt) {
                                const taskId = evt.item.dataset.taskId;
                                const newIndex = evt.newIndex;
                                
                                try {
                                    await fetch(`/tasks/${taskId}/order`, {
                                        method: 'PATCH',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                        },
                                        body: JSON.stringify({
                                            sort_order: newIndex,
                                            show_order: newIndex
                                        })
                                    });
                                } catch (error) {
                                    console.error('Error updating task order:', error);
                                }
                            }
                        });
                    }
                }

                // Initialize on page load
                initSortable();

                // Update tasks function
                async function updateTasks(url = null) {
                    const searchQuery = searchInput ? encodeURIComponent(searchInput.value) : '';
                    const status = statusFilter ? statusFilter.value : 'all';
                    const fetchUrl = url || `{{ route('task-lists.show', $taskList) }}?search=${searchQuery}&status=${status}`;
                    
                    try {
                        const response = await fetch(fetchUrl, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const html = await response.text();
                        
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;
                        const newTasksList = tempDiv.querySelector('.tasks-list');
                        
                        if (newTasksList) {
                            tasksContainer.innerHTML = newTasksList.innerHTML;
                            initSortable();
                        }
                    } catch (error) {
                        console.error('Error fetching tasks:', error);
                    }
                }

                // Event listeners
                if (searchInput) {
                    let timeout;
                    searchInput.addEventListener('input', () => {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => updateTasks(), 300);
                    });
                }

                if (sortBy) {
                    sortBy.addEventListener('change', function(e) {
                        const url = e.target.value;
                        window.history.pushState({}, '', url);
                        updateTasks(url);
                    });
                }

                if (statusFilter) {
                    statusFilter.addEventListener('change', () => updateTasks());
                }
            </script>
        </div>
    </div>
</x-app-layout> 