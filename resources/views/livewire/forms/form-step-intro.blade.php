<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">

    <div class="form-group">
        <label value="" />
            <div name="intro-text">
                {{ $jsonQuestion->question_title }}
                {{ $jsonQuestion->question_content }}
            </div>


        <br/>
        <p>
            {{ $jsonQuestion->question_options->extra_text }}
        </p>
    </div>

</x-layouts.form>
