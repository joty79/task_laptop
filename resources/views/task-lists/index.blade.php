<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Task Lists') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Create New Task List Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <form action="{{ route('task-lists.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="title" value="New Task List" class="dark:text-gray-300" />
                                <x-text-input 
                                    id="title" 
                                    name="title" 
                                    type="text" 
                                    class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input-label for="description" value="Description (Optional)" class="dark:text-gray-300" />
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="3"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm"
                                ></textarea>
                            </div>
                            <div>
                                <x-primary-button class="w-full justify-center">
                                    Create List
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Task Lists -->
            <div class="space-y-4">
                @foreach($taskLists as $list)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <a href="{{ route('task-lists.show', $list) }}" 
                                   class="text-xl font-bold text-gray-800 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400">
                                    {{ $list->title }}
                                </a>
                                <div class="flex items-center space-x-2">
                                    <!-- Edit Icon -->
                                    <a href="{{ route('task-lists.edit', $list) }}" 
                                       class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 relative group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        <!-- Tooltip -->
                                        <span class="absolute hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 -top-8 -left-2">
                                            Edit
                                        </span>
                                    </a>

                                    <!-- Delete Icon -->
                                    <form action="{{ route('task-lists.destroy', $list) }}" method="POST" class="relative group">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this list?')"
                                                class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            <!-- Tooltip -->
                                            <span class="absolute hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 -top-8 -left-2">
                                                Delete
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if($list->description)
                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $list->description }}
                                </div>
                            @endif
                            <div class="mt-4">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $list->completed_tasks_count }} / {{ $list->tasks_count }} tasks completed
                                </div>
                                <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" @style(['width' => $list->progressPercentage() . '%'])></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout> 