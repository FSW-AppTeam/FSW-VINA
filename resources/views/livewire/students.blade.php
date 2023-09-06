<div>
    @foreach ($students as $student)
        {{--                <div class="p-2 float-end" style="display: inline-block;" wire:key="{{ $student['id'] }}" id="{{ $student['id'] }}">{{ $student['name'] }}</div>--}}
        <div class="p-2" wire:key="{{ $student['id'] }}" id="{{ $student['id'] }}">{{ $student['name'] }}</div>
    @endforeach


    {{--    <style scope>--}}
    {{--        .students-balk {--}}
    {{--            padding-left: 15px !important;--}}
    {{--        }--}}

    {{--    </style>--}}
</div>
