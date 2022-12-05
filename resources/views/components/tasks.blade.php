<ol class="wtree">
        @foreach ($tasks as $task)
            <x-task :task="$task" :users="$users" :statuses="$statuses"/>
        @endforeach
</ol>
