<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div>
        <label class="pb-1 col-10 text-center">{{ $jsonQuestion->question_content }}</label>


        <div class="form-group">
{{--            Friends here step 10{{ json_encode($friends) }}--}}

            @foreach($friends as $friend)
                 <button type="button"
                           wire:click="removeStudent({{$friend['id']}})"
                           class="p-3">
                    {{$friend['name']}}
                </button>
            @endforeach
        </div>

        <hr />

        <div class="form-group">
            <input type="text" wire:model="friends" id="active-friends" class="active-student" hidden/>



                @foreach ($this->form->getStudentsWithoutActiveStudent() as $student)
                <div class="btn">
                    <livewire:student-component wire:key="{{$student['id']}}" :id="$student['id']" :name="$student['name']"/>
                </div>
                @endforeach



        </div>
    </div>


</x-layouts.form>



