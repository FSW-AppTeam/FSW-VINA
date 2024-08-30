<div class="text-center block-students-vertical line-students " data-student-list>
    <button type="button"
            class="p-2 btn-circle btn-xl selected-btn boxed-btn-0 student-shadow-flex
             {{$showShrink?'selected-btn-shrink':''}}
            @if($bounceOut) bounce-out-left-btn @endif"
            id="{{isset($subject)?$subject['id']:''}}">
        {{isset($subject)?$subject['name']:''}}
    </button>
    @foreach($students as $key => $student)
        <button type="button"
                class="p-2 btn-circle btn-xl selected-btn boxed-btn-0 fadeOut student-shadow-flex
                @if($bounceOut) move-to-left-btn @endif"
                id="step-student-button-{{$key}}">
            {{isset($student)?$student['name']:''}}
        </button>
    @endforeach
</div>