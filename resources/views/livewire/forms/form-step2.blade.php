<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div class="mt-4">
        @if($setPage)
            <div class="form-group set-fade-in">
                    <h6 class="pb-2">{{ $jsonQuestion->question_content }}</h6>
                    <input type="text" wire:model="name" class="form-control style-input" name="student-name" @disabled($jsonQuestionNameList->active_list)>

                <p class="mt-3 sub-head-text">
                    Je achternaam is niet nodig. Als iemand in je klas dezelfde voornaam heeft als jij, dan kun je de
                    eerste letter van je achternaam toevoegen.
                </p>

                <p class="mt-3 sub-head-text">
                    <span style="text-decoration: underline">Let op!</span> Je moet je naam invullen zodat je
                    klasgenoten ook vragen over jou kunnen beantwoorden. Je naam wordt na afloop van dit onderzoek
                    verwijderd.
                </p>
            </div>
        @endif
    </div>
</x-layouts.form>




