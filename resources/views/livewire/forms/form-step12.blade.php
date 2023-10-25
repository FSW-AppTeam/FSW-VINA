<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">

    @if($setPage)
        <div class="set-fade-in">
            <h6 class="pb-3 mt-4 text-center mx-4">{{ $jsonQuestion->question_content }}</h6>

            <div class="form-group student-list col border-end d-flex justify-content-center align-items-center row">

                @if (empty($startFriend))
                    <div class="step-notification alert alert-danger text-center">
                        <p>{{ $jsonQuestion->question_options->error_text }}</p>
                    </div>

                @else
                    <div class="start-friend justify-content-center row">
                        <div class=" text-center justify-content-center p-2 start-friend-btn">
                            <div id="{{$startFriend['id']}}"
                                 class="p-2 btn-circle btn-xl studentBtn start-friend-btn-v2  @if(strlen($startFriend['name']) > 8) circle-text @endif">
                                {{$startFriend['name']}}
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($friends))
                        <?php $rowZindex = 100;  $firstRun = false; ?>

                    @foreach($friendsList as $key => $newFriends)
                        @if(count($friendsList[$key]) % 5 === 0)
                            {{--                        <h1>jaaazzz  {{$key}}</h1>--}}
                            <div
                                class="justify-content-center row student-block-v2 selected-friends-row-v4 question-step-friends  @if($key !== 0) qv2 @endif"
                                id="selected-row-{{$key}}" style="z-index: {{$rowZindex - $key}}">

                                @else
                                    {{--                                <h1>neee  {{$key}} --- {{ count($friendsList) }}</h1>--}}

                                    <div
                                        class="justify-content-center row student-block-v2 selected-friends-row-v4 @if(count($friendsList) === 1) v2 @endif @if($key !== 0) selected-friends-row-v3 @endif"
                                        id="selected-row-{{$key}}" style="z-index: 0">
                                        @endif
                                        @foreach($newFriends as $k => $friend)
                                            <button type="button"
                                                    id="selected-friend-{{$k}}"
                                                    wire:click="removeSelectedStudentId({{$friend['id'], $key}})"
                                                    class="p-2 btn-circle btn-xl selected-btn friends-v2
                                                    @if($k === 4) boxed-btn-4 @endif
                                                    @if($k === 3) boxed-btn-3 @endif
                                                    @if($k === 2) boxed-btn-2 @endif
                                                    @if($k === 1) boxed-btn-1 @endif
                                                    @if($k === 0) boxed-btn-0 @endif
                                                    @if($k === 0 && count($friendsList) > 1) swithced @endif
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

                            <p class="sub-head-text pt-4 student-list">{{ $jsonQuestion->question_options->extra_text }}</p>

                            <div class="form-group students-overview mb-3">
                                <div class="">
                                    <div class="row">
                                        @foreach ($this->students as $key => $student)
                                            <livewire:student-fade-component
                                                wire:key="students-fade-selected-v2{{ $student['id'] }}"
                                                :id="$student['id']" :name="$student['name']"
                                                :selected-friends-ids="$selectedFriendsIds"/>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
            </div>
    @endif
</x-layouts.form>

