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
                                <form action="{{ route('task-lists.destroy', $list) }}" method="POST" class="ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this list?')"
                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
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