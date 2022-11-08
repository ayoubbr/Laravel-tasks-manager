<ol class="wtree">
    @foreach ($tasks as $task)
            <x-task :task="$task" />
    @endforeach
</ol>