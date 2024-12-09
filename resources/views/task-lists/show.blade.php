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
                            <div class="flex items-center gap-1">
                                <select 
                                    id="sort-select"
                                    class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="deadline" {{ request('sort', 'deadline') === 'deadline' ? 'selected' : '' }}>
                                        Deadline
                                    </option>
                                    <option value="priority" {{ request('sort') === 'priority' ? 'selected' : '' }}>
                                        Priority
                                    </option>
                                    <option value="completion" {{ request('sort') === 'completion' ? 'selected' : '' }}>
                                        Completion
                                    </option>
                                    <option value="custom" {{ request('sort') === 'custom' ? 'selected' : '' }}>
                                        Custom
                                    </option>
                                </select>
                                <button 
                                    id="sort-direction"
                                    type="button"
                                    class="p-1.5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors duration-200"
                                    title="Toggle sort direction"
                                >
                                    <svg class="w-4 h-4 transform transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 16h7m-7-8h12m4 0l-3-3m3 3l-3 3m3 5l-3-3m3 3l-3 3" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Filter Options -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Show:</span>
                            <select 
                                id="status-select"
                                class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="all" {{ !request('status') || request('status') === 'all' ? 'selected' : '' }}>
                                    All Tasks
                                </option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                                    Pending Only
                                </option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>
                                    Completed Only
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div id="tasksWrapper" class="relative transition-all duration-200">
                    <div id="tasksContainer" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @include('task-lists.partials.tasks-list', ['tasks' => $tasks])
                    </div>
                </div>
            </div>

            <script>
                const tasksContainer = document.querySelector('.tasks-list');
                const tasksWrapper = document.getElementById('tasksWrapper');
                const searchInput = document.getElementById('taskSearch');
                const suggestionText = document.getElementById('suggestionText');
                const statusSelect = document.getElementById('status-select');
                const sortSelect = document.getElementById('sort-select');
                const sortDirection = document.getElementById('sort-direction');
                let sortableInstance = null;
                let maxHeight = null;
                let lastCustomOrder = new Map();
                let isAscending = true;

                // Function to toggle sort direction icon
                function updateSortDirectionIcon() {
                    const svg = sortDirection.querySelector('svg');
                    svg.style.transform = isAscending ? 'rotate(0deg)' : 'rotate(180deg)';
                    sortDirection.title = isAscending ? 'Sort Descending' : 'Sort Ascending';
                }

                // Function to save current task order
                function saveCurrentOrder() {
                    if (sortSelect.value === 'custom') {
                        lastCustomOrder.clear();
                        document.querySelectorAll('.task-item').forEach((item, index) => {
                            lastCustomOrder.set(item.dataset.taskId, index);
                        });
                    }
                }

                // Function to restore custom order
                async function restoreCustomOrder() {
                    if (lastCustomOrder.size === 0) return;

                    const tasks = Array.from(document.querySelectorAll('.task-item'));
                    const orderedTasks = tasks.sort((a, b) => {
                        const orderA = lastCustomOrder.get(a.dataset.taskId) ?? 0;
                        const orderB = lastCustomOrder.get(b.dataset.taskId) ?? 0;
                        return orderA - orderB;
                    });

                    if (!isAscending) {
                        orderedTasks.reverse();
                    }

                    // Update DOM and server
                    orderedTasks.forEach((task, index) => {
                        tasksContainer.appendChild(task);
                        updateTaskOrder(task.dataset.taskId, index);
                    });
                }

                // Function to update task order on server
                async function updateTaskOrder(taskId, newIndex) {
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

                // Function to get initial max height
                function setInitialMaxHeight() {
                    if (tasksWrapper && !maxHeight) {
                        maxHeight = tasksWrapper.offsetHeight;
                        tasksWrapper.style.minHeight = `${maxHeight}px`;
                    }
                }

                // Function to preserve viewport height
                function preserveHeight() {
                    if (tasksWrapper && maxHeight) {
                        tasksWrapper.style.minHeight = `${maxHeight}px`;
                    }
                }

                // Function to update height while maintaining minimum
                function updateHeight() {
                    if (tasksWrapper) {
                        const currentHeight = tasksContainer.offsetHeight;
                        // Only update maxHeight if current height is larger
                        if (currentHeight > maxHeight) {
                            maxHeight = currentHeight;
                        }
                        // Always maintain at least the max height
                        tasksWrapper.style.minHeight = `${maxHeight}px`;
                    }
                }

                // Function to update suggestion text
                function updateSuggestion(inputValue) {
                    if (!suggestionText) return;
                    
                    const tasks = Array.from(document.querySelectorAll('.task-item')).map(item => {
                        const titleEl = item.querySelector('.font-medium');
                        return titleEl ? titleEl.textContent.trim() : '';
                    });

                    const searchTerm = inputValue.toLowerCase();
                    const suggestion = tasks.find(task => {
                        const taskLower = task.toLowerCase();
                        // Exact match for special characters
                        return taskLower.startsWith(searchTerm) && searchTerm !== taskLower;
                    });

                    if (suggestion && searchTerm) {
                        const remainingPart = suggestion.substring(searchTerm.length);
                        suggestionText.innerHTML = remainingPart;
                        
                        // Calculate and set the suggestion offset
                        const tempSpan = document.createElement('span');
                        tempSpan.style.visibility = 'hidden';
                        tempSpan.style.position = 'absolute';
                        tempSpan.style.fontSize = window.getComputedStyle(searchInput).fontSize;
                        tempSpan.textContent = searchTerm;
                        document.body.appendChild(tempSpan);
                        const offset = tempSpan.offsetWidth;
                        document.body.removeChild(tempSpan);
                        
                        document.documentElement.style.setProperty('--suggestion-offset', offset + 'px');
                    } else {
                        suggestionText.innerHTML = '';
                    }
                }

                // Initialize Sortable
                function initSortable() {
                    if (sortableInstance) {
                        sortableInstance.destroy();
                        sortableInstance = null;
                    }

                    if (sortSelect.value === 'custom' && tasksContainer) {
                        sortableInstance = Sortable.create(tasksContainer, {
                            handle: '.drag-handle',
                            animation: 150,
                            draggable: '.task-item',
                            onStart: function() {
                                // Save the current order before dragging
                                saveCurrentOrder();
                            },
                            onEnd: async function(evt) {
                                const taskId = evt.item.dataset.taskId;
                                const newIndex = evt.newIndex;
                                
                                try {
                                    await updateTaskOrder(taskId, newIndex);
                                    // Update the stored order
                                    lastCustomOrder.set(taskId, newIndex);
                                } catch (error) {
                                    console.error('Error updating task order:', error);
                                }
                            }
                        });
                    }
                }

                // Update tasks function
                async function updateTasks() {
                    preserveHeight();
                    
                    const rawSearchQuery = searchInput ? searchInput.value : '';
                    const searchQuery = encodeURIComponent(rawSearchQuery)
                        .replace(/%2B/g, '+')
                        .replace(/%23/g, '#')
                        .replace(/%26/g, '&')
                        .replace(/%25/g, '%');
                    
                    const status = statusSelect ? statusSelect.value : 'all';
                    const sort = sortSelect ? sortSelect.value : 'deadline';
                    const wasCustom = sort === 'custom';
                    
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', searchQuery);
                    url.searchParams.set('status', status);
                    url.searchParams.set('sort', sort);
                    url.searchParams.set('direction', isAscending ? 'asc' : 'desc');
                    
                    try {
                        const response = await fetch(url.toString(), {
                            headers: { 
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json'
                            }
                        });
                        
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        
                        const html = await response.text();
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;
                        const newTasksList = tempDiv.querySelector('.tasks-list');
                        
                        if (newTasksList) {
                            tasksContainer.innerHTML = newTasksList.innerHTML;
                            if (wasCustom) {
                                await restoreCustomOrder();
                            } else if (!isAscending) {
                                // Reverse DOM elements for non-custom sort
                                Array.from(tasksContainer.children)
                                    .reverse()
                                    .forEach(task => tasksContainer.appendChild(task));
                            }
                            initSortable();
                            window.history.pushState({}, '', url.toString());
                            updateHeight();
                            updateSuggestion(rawSearchQuery);
                        }
                    } catch (error) {
                        console.error('Error fetching tasks:', error);
                    }
                }

                // Event listeners with debounce for all changes
                function debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                const debouncedUpdate = debounce(updateTasks, 300);

                if (searchInput) {
                    searchInput.addEventListener('input', (e) => {
                        updateSuggestion(e.target.value);
                        debouncedUpdate();
                    });

                    searchInput.addEventListener('keydown', (e) => {
                        if (e.key === 'Tab' && suggestionText.textContent) {
                            e.preventDefault();
                            searchInput.value += suggestionText.textContent;
                            suggestionText.textContent = '';
                            debouncedUpdate();
                        }
                    });
                }

                if (sortDirection) {
                    sortDirection.addEventListener('click', () => {
                        isAscending = !isAscending;
                        updateSortDirectionIcon();
                        if (sortSelect.value === 'custom') {
                            const tasks = Array.from(tasksContainer.children);
                            tasks.reverse().forEach(task => tasksContainer.appendChild(task));
                            tasks.forEach((task, index) => {
                                updateTaskOrder(task.dataset.taskId, index);
                            });
                        } else {
                            debouncedUpdate();
                        }
                    });
                }

                if (statusSelect) {
                    statusSelect.addEventListener('change', () => {
                        preserveHeight();
                        debouncedUpdate();
                    });
                }

                // Initialize
                setInitialMaxHeight();
                initSortable();
                updateSortDirectionIcon();
                if (sortSelect.value === 'custom') {
                    saveCurrentOrder();
                }

                // Update max height when new tasks are added
                document.addEventListener('submit', (e) => {
                    if (e.target.matches('form[action*="tasks"]')) {
                        setTimeout(() => {
                            updateHeight();
                            if (sortSelect.value === 'custom') {
                                saveCurrentOrder();
                            }
                        }, 500);
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout> 