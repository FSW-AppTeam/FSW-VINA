<x-layouts.form :step-id="$stepId"
                :loading="$loading"
                :json-question="$jsonQuestion">
    <div class="set-fade-in">
        <h6 class="pb-3 mt-4 text-center mx-4">{{ $jsonQuestion->question_content }}</h6>
        <div class="form-group student-list col border-end d-flex justify-content-center align-items-center row">
            <livewire:components.student-selected
                wire:key="students-selected-{{ time() }}"
                :subject="$subject"
                :selectedStudents="$selectedStudents"
            />
        </div>

        <p class="sub-head-text pt-4 student-list">{{ $jsonQuestion->question_options['extra_text'] }}</p>
        <div class="form-group students-overview mb-3">
            <div class="row">
                @foreach ($this->students as $student)
                    <livewire:components.student-fade
                            wire:key="students-fade-{{ $student['id'] . time() }}"
                            :id="$student['id']"
                            :name="$student['name']"
                            :nextId="$this->students[0]['id']"
                            :selectedStudents="$selectedStudents"/>
                @endforeach
                <div wire:loading
                     wire:target="setStudent">
                    <div id="overlay">
                        <div id="overlaytext">
                            <span class="spinner-border spinner-border-sm wait" role="status" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>

                <div wire:loading
                     wire:target="removeStudent">
                    <div id="overlay">
                        <div id="overlaytext">
                            <span class="spinner-border spinner-border-sm wait" role="status" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.form>
