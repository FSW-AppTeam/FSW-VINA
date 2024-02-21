<x-layouts.form :step-id="$stepId"
                :next-enabled="$nextEnabled"
                :back-enabled="$backEnabled"
                :json-question="$jsonQuestion">
    <div class="set-fade-in">
        <h6 class="pb-3 mt-4 text-center mx-4">{{ $jsonQuestion->question_content }}</h6>

        <div class="form-group student-list col border-end d-flex justify-content-center align-items-center row">

            @if (empty($startFriend))
                <div class="step-notification alert alert-danger text-center">
                    <p>{{ $jsonQuestion->question_options->error_text }}</p>
                </div>
            @endif

            <div
                class="justify-content-center row student-block mb-1 selected-friends-row"
                id="selected-row-0" wire:key="student-fade-div-key{{ time() }}"
                style="z-index: 0">

                <button type="button"
                        class="p-2 btn-circle btn-xl selected-btn fadeOut
                        @if($disappear) bounce-out-left-btn @endif"
                        id="start-friend-bounce">
                    {{$startFriend['name']}}
                </button>

                @foreach($friends as $key => $newFriends)
                    <button type="button"
                            id="selected-friend-{{$key}}"
                            wire:click="removeSelectedStudentId({{$newFriends['id'], $key}})"
                            class="p-2 btn-circle btn-xl fadeOut
                                @if($key === 3) boxed-btn-4 @endif
                                @if($key === 2) boxed-btn-3 @endif
                                @if($key === 1) boxed-btn-2 @endif
                                @if($key === 0) boxed-btn-1 @endif
                                @if($disappear) bounce-out-left-btn @endif
                                ">
                        {{$newFriends['name']}}
                    </button>
                @endforeach
            </div>
        </div>

        <p class="sub-head-text pt-4 student-list">{{ $jsonQuestion->question_options->extra_text }}</p>

        <div class="form-group students-overview mb-3">
            <div class="">
                <div class="row">
                    @foreach ($this->students as $key => $student)
                        <livewire:student-fade-component
                            wire:key="students-fade-selected-{{ $student['id'] . time() }}"
                            :id="$student['id']"
                            :nextId="$this->students[0]['id']"
                            :name="$student['name']"
                            :selected-friends-ids="$selectedFriendsIds"
                            />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.form>
