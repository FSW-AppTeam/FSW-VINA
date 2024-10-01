<div wire:model="selectedStudents">
    <?php $rowZindex = 100; ?>
    <div id="start-friend-bounce-all">
        @foreach($rowSelectedStudents as $keyRow => $students)
            <div class="justify-content-center row student-block selected-friends-row mb-1"
                 id="selected-row-{{$keyRow}}" wire:key="student-fade-div-key-{{$keyRow}}-{{ time() }}"
                 style="z-index: {{$rowZindex - 1}}">
                @foreach($students as $key => $student)
                    @if($subject && $subject['id'] == $student['id'])
                        <button type="button"
                                class="p-2 btn-circle btn-xl selected-btn fadeOut"
                                id="start-friend-bounce">
                            {{$student['name']}}
                        </button>
                        @continue
                    @endif

                    <button type="button"
                            id="selected-friend-{{$key}}"
                            wire:click="removeSelectedStudent({{$student['id']}})"
                            class="p-2 btn-circle btn-xl
                            {{$subject?'fadeOut':'selected-btn'}}
                                boxed-btn-{{$key % 5}}
                            ">
                        {{$student['name']}}
                    </button>
                @endforeach
            </div>
        @endforeach
    </div>
    <div wire:loading
         wire:target="removeSelectedStudent">
        <div id="overlay">
            <div id="overlaytext">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </div>
        </div>
    </div>
</div>