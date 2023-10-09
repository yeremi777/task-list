@section('title', isset($task) ? 'Edit Task' : 'Add Task')

@section('content')
    <form method="post" action="{{ isset($task) ? route('tasks.update', ['task' => $task->id]) : route('tasks.store') }}">
        @csrf
        @isset($task)
            @method('PUT')
        @endisset
        <div class="mb-4">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="border @error('title') border-red-500 @enderror"
                value="{{ isset($task) ? old('title', $task->title) : old('title') }}">
            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="border @error('description') border-red-500 @enderror"
                rows="5">{{ isset($task) ? old('description', $task->description) : old('description') }}</textarea>
            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="long_description">Long Description</label>
            <textarea name="long_description" id="long_description"
                class="border @error('long_description') border-red-500 @enderror" rows="10">{{ isset($task) ? old('long_description', $task->description) : old('long_description') }}</textarea>
            @error('long_description')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-2 items-center">
            <button type="submit" class="btn">
                @isset($task)
                    Edit Task
                @else
                    Add Task
                @endisset
            </button>

            <a href="{{ route('tasks.index') }}" class="link">Cancel</a>
        </div>
    </form>
@endsection
