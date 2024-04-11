<x-layouts.form :step-id="$stepId"
                :next-enabled="$nextEnabled"
                :back-enabled="$backEnabled"
                :json-question="$jsonQuestion">
    <div class="set-fade-in">
        <h6 class="pb-3 mt-4 text-center mx-4">{{ $jsonQuestion->question_content }}</h6>

        <div class="form-group student-list col border-end d-flex justify-content-center align-items-center row">
            @if(!empty($friends))
                    <?php $rowZindex = 100; ?>

                @foreach($friendsList as $key => $newFriends)
                    @if(count($friendsList[$key]) % 5 === 0)
                        <div class="justify-content-center row student-block selected-friends-row mb-1"
                             id="selected-row-{{$key}}" style="z-index: {{$rowZindex - $key}}">
                    @else
                        <div
                            class="justify-content-center row student-block mb-1  @if($key !== 0) selected-friends-row-v2 @endif"
                            id="selected-row-{{$key}}" style="z-index: 0">
                    @endif

                        @foreach($newFriends as $k => $friend)
                            <button type="button"
                                    wire:click="removeSelectedStudentId({{$friend['id'], $key}})"
                                    id="selected-friend-{{$k}}"
                                    class="p-2 btn-circle btn-xl selected-btn
                                    @if($k === 4) boxed-btn-4 @endif
                                    @if($k === 3) boxed-btn-3 @endif
                                    @if($k === 2) boxed-btn-2 @endif
                                    @if($k === 1) boxed-btn-1 @endif
                                    @if($k === 0 && count($newFriends) > 1) boxed-btn-0 @endif
                                    ">
                                {{$friend['name']}}
                            </button>
                        @endforeach

                    </div>
                @endforeach
            @else
                <div class="empty-students-row">&nbsp;</div>
            @endif
        </div>

        <p class="sub-head-text pt-4 student-list">{{ $jsonQuestion->question_options['extra_text'] }}</p>

        <div class="form-group students-overview mb-3">
            <div class="">
                <div class="row">
                    @foreach ($this->form->getStudentsWithoutActiveStudent() as $student)
                        {{--  use strict unique key in wire:key attr  --}}
                        <livewire:student-fade-component
                            wire:key="students-fade-step-11-{{ $student['id'] . time() }}"
                            :id="$student['id']"
                            :name="$student['name']"
                            :selected-friends-ids="$selectedFriendsIds"/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.form>



