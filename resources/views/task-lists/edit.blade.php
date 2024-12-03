<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-xl mx-auto">
            <div class="w-16">
                <!-- Empty div for spacing -->
            </div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center flex-1">
                Edit Task List
            </h2>
            <div class="w-16 text-right">
                <a href="{{ route('task-lists.show', $taskList) }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                    ← Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <form action="{{ route('task-lists.update', $taskList) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="title" value="Title" class="dark:text-gray-300" />
                                <x-text-input 
                                    id="title" 
                                    name="title" 
                                    type="text" 
                                    class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300" 
                                    :value="old('title', $taskList->title)"
                                    required 
                                />
                            </div>
                            <div>
                                <x-input-label for="description" value="Description" class="dark:text-gray-300" />
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="3"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm"
                                >{{ old('description', $taskList->description) }}</textarea>
                            </div>
                            <div>
                                <x-primary-button class="w-full justify-center">
                                    Update List
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 