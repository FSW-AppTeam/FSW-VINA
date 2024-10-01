<div>
        @dd("DEPRECATED?? - student.blade.php")
    @foreach ($students as $student)
        <div class="p-2" wire:key="student-key-{{ $student['id'] }}" id="{{ $student['id'] }}">{{ $student['name'] }}</div>
    @endforeach
</div>
