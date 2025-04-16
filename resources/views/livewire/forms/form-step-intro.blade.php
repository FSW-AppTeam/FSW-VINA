<x-layouts.form
    :step-id="$stepId"
    :loading="$loading"
    :json-question="$jsonQuestion">
    <div class="">
        {!! langDatabase('form.step_intro') !!}
    </div>
</x-layouts.form>
