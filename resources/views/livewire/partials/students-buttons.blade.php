<div class="text-center block-students-vertical line-students " data-student-list>
    <button type="button"
            id="step-student-button-subject"
            class="p-2 btn-circle btn-xl selected-btn boxed-btn-0 student-shadow-flex
             {{$showShrink?'selected-btn-shrink':''}}"
            id="{{isset($subject)?$subject['id']:''}}">
        {{isset($subject)?$subject['name']:''}}
    </button>
    @foreach($students as $key => $student)
        <button type="button"
                class="p-2 btn-circle btn-xl selected-btn boxed-btn-0 fadeOut student-shadow-flex"
                id="step-student-button-{{$key}}">
            {{isset($student)?$student['name']:''}}
        </button>
    @endforeach
</div>