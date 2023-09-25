<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div>
        <label class="pb-1 col-10">{{ $jsonQuestion->question_content }}</label>

        <div class="form-group">
            @foreach($friends as $friend)
                 <button type="button"
                         wire:key="{{$friend['id']}}"
                           wire:click="removeSelectedStudentId({{$friend['id']}})"
                           class="p-3 btn-circle btn-xl">
                    {{$friend['name']}}
                </button>
            @endforeach
        </div>

        <div class="question-options-extra-text pt-3"><p>{{ $jsonQuestion->question_options->extra_text }}</p></div>

        <hr />

        <div class="form-group">
            <input type="text" wire:model="friends" id="friends" class="active-friends" hidden/>

            @foreach ($this->form->getStudentsWithoutActiveStudent() as $student)
            <div class="btn">
                <livewire:student-component wire:key="{{$student['id']}}" :id="$student['id']" :name="$student['name']"/>
            </div>
            @endforeach

        </div>
    </div>
</x-layouts.form>



