<div>
    <div class="d-flex flex-row float-end students-balk" style="display: inline-block;">
        @foreach ($students as $student)
            <div wire:key="{{ $student['id'] }}">
                <div class="p-2 float-end" style="display: inline-block;" id="{{ $student['id'] }}">{{ $student['name'] }}</div>
            </div>
        @endforeach
    </div>



{{--    <style scope>--}}
{{--        .students-balk {--}}
{{--            padding-left: 15px !important;--}}
{{--        }--}}

{{--    </style>--}}
</div>
