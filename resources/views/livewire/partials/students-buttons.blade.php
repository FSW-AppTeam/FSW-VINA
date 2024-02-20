<div class="mt-4 text-center block-students-vertical line-students " data-student-list>
    <button type="button"
            class="p-2 btn-circle btn-xl selected-btn boxed-btn-0 student-shadow-flex
            @if($disappear) bounce-out-left-btn @endif"
            id="{{$startStudent['id']}}">
        {{$startStudent['name']}}
    </button>
    @foreach($students as $key => $student)
        <button type="button"
                class="p-2 btn-circle btn-xl selected-btn boxed-btn-0 fadeOut student-shadow-flex
                @if($disappear) move-to-left-btn @endif"
                id="step-student-button-{{$key}}">
            {{$student['name']}}
        </button>
    @endforeach
</div>
