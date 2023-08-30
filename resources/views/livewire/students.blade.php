<div>
    <div class="align-middle float-end" style="display: inline-block; position: relative">
        @foreach ($students as $student)
            <div wire:key="{{ $student['id'] }}">
                <div class="p-2 float-end" style="display: inline-block; "  id="{{ $student['id'] }}">{{ $student['name'] }}</div>
            </div>
        @endforeach
    </div>
</div>
