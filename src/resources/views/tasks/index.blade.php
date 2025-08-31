@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Task Creation Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm p-6 border">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Add New Task</h2>
            
            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >{{ old('description') }}</textarea>
                </div>
                
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select 
                        id="priority" 
                        name="priority"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
                
                <button 
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200"
                >
                    Add Task
                </button>
            </form>
        </div>

        <!-- Task Statistics -->
        <div class="bg-white rounded-lg shadow-sm p-6 border mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
            
            @php
                $totalTasks = $tasks->count();
                $completedTasks = $tasks->where('completed', true)->count();
                $pendingTasks = $totalTasks - $completedTasks;
                $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
            @endphp
            
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Total Tasks</span>
                    <span class="text-sm font-medium">{{ $totalTasks }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Completed</span>
                    <span class="text-sm font-medium text-green-600">{{ $completedTasks }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Pending</span>
                    <span class="text-sm font-medium text-orange-600">{{ $pendingTasks }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Completion Rate</span>
                    <span class="text-sm font-medium">{{ $completionRate }}%</span>
                </div>
                
                <!-- Progress bar -->
                <div class="mt-3">
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $completionRate }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Tasks</h2>
                    
                    <!-- Filter buttons -->
                    <div class="flex space-x-2" x-data="{ filter: 'all' }">
                        <button 
                            @click="filter = 'all'"
                            :class="filter === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-3 py-1 text-xs rounded-md hover:opacity-80 transition"
                            onclick="filterTasks('all')"
                        >
                            All
                        </button>
                        <button 
                            @click="filter = 'pending'"
                            :class="filter === 'pending' ? 'bg-orange-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-3 py-1 text-xs rounded-md hover:opacity-80 transition"
                            onclick="filterTasks('pending')"
                        >
                            Pending
                        </button>
                        <button 
                            @click="filter = 'completed'"
                            :class="filter === 'completed' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-3 py-1 text-xs rounded-md hover:opacity-80 transition"
                            onclick="filterTasks('completed')"
                        >
                            Completed
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="divide-y divide-gray-200">
                @forelse($tasks as $task)
                    <div class="p-6 task-item" data-status="{{ $task->completed ? 'completed' : 'pending' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-3 flex-1">
                                <!-- Checkbox -->
                                <input 
                                    type="checkbox" 
                                    {{ $task->completed ? 'checked' : '' }}
                                    class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded task-checkbox"
                                    data-task-id="{{ $task->id }}"
                                >
                                
                                <!-- Task content -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900 {{ $task->completed ? 'line-through opacity-60' : '' }}">
                                        {{ $task->title }}
                                    </h3>
                                    
                                    @if($task->description)
                                        <p class="text-sm text-gray-500 mt-1 {{ $task->completed ? 'line-through opacity-60' : '' }}">
                                            {{ $task->description }}
                                        </p>
                                    @endif
                                    
                                    <div class="flex items-center space-x-4 mt-2">
                                        <!-- Priority -->
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                            @if($task->priority === 'high') bg-red-100 text-red-800
                                            @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800
                                            @endif
                                        ">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                        
                                        <!-- Created date -->
                                        <span class="text-xs text-gray-400">
                                            {{ $task->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Delete button -->
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="ml-4">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit"
                                    class="text-red-400 hover:text-red-600 transition"
                                    onclick="return confirm('Are you sure you want to delete this task?')"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="text-gray-400 mb-2">
                            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">No tasks yet. Create your first task!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function filterTasks(status) {
    const tasks = document.querySelectorAll('.task-item');
    tasks.forEach(task => {
        const taskStatus = task.getAttribute('data-status');
        if (status === 'all' || status === taskStatus) {
            task.style.display = 'block';
        } else {
            task.style.display = 'none';
        }
    });
}

// Task completion toggle
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.task-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const taskId = this.getAttribute('data-task-id');
            const isCompleted = this.checked;
            
            axios.put(`/tasks/${taskId}`, {
                completed: isCompleted
            })
            .then(response => {
                if (response.data.success) {
                    // Refresh page to update UI and statistics
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error updating task:', error);
                // Revert checkbox state
                this.checked = !isCompleted;
            });
        });
    });
});
</script>
@endsection