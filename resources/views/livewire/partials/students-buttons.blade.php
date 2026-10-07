<div class="text-center block-students-vertical line-students " data-student-list
     style="{{ $centerSubject ? 'left: 0; width: 100%; margin-left: 0; justify-content: flex-start; min-height: 80px;' : '' }}">
    <button type="button"
            id="step-student-button-subject"
            class="p-2 btn-circle btn-xl selected-btn boxed-btn-0 student-shadow-flex
             {{$showShrink?'selected-btn-shrink':''}}"
            style="{{ $centerSubject ? 'position: absolute; left: 50%; margin-left: -40px;' : '' }}"
            id="{{isset($subject)?$subject['id']:''}}">
        {{isset($subject)?$subject['name']:''}}
    </button>
    @foreach($students as $key => $student)
        <button type="button"
                class="p-2 btn-circle btn-xl selected-btn boxed-btn-0 fadeOut student-shadow-flex"
                style="{{ $centerSubject ? 'flex-shrink: 0;' : '' }}{{ $centerSubject && $loop->first ? 'margin-left: calc(50% + 40px);' : '' }}"
                id="step-student-button-{{$key}}">
            {{isset($student)?$student['name']:''}}
        </button>
    @endforeach
</div>