<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div>
        <label class="pb-1 col-10">{{ $jsonQuestion->question_content }}</label>

        <div class="text-center p-2">
                <div id="{{$startFriend['id']}}"
                        class="p-3 btn-circle btn-xl" >
                    {{$startFriend['name']}}
                </div>
        </div>

        <div class="form-group text-center">
            @foreach($friends as $friend)
                 <button type="button"
{{--                         wire:key="friend-items-{{ now() }}"--}}
                         wire:click="removeSelectedStudentId({{$friend['id']}})"
                         id="{{$friend['id']}}"
                         class="p-3 btn-circle btn-xl">
                    {{$friend['name']}}
                </button>
            @endforeach
        </div>

        <div class="question-options-extra-text pt-3"><p>{{ $jsonQuestion->question_options->extra_text }}</p></div>

        <div class="form-group">
{{--            <input type="text" wire:model="startFriend" id="startFriend" class="active-start-friend" hidden/>--}}
{{--            <input type="text" wire:model="friends" id="friends" class="active-friends" hidden/>--}}

            @foreach ($this->students as $key => $student)
                @if($key > 0)
                        <livewire:student-fade-component wire:key="items-fade-{{ now() }}" :id="$student['id']" :name="$student['name']" :selected-friends-Ids="$selectedFriendsIds"/>
                @endif
            @endforeach
        </div>
    </div>
</x-layouts.form>



