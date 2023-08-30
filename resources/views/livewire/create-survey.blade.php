<div>

    <div>
        @if($success)
            <span class="block mb-4 text-green-500">Post saved successfully.</span>
        @endif

        @if($errors->any())
            {!! implode('', $errors->all('<div class="text-red">:message</div>')) !!}
        @endif

        {{--        @php--}}
        {{--            dump('me stepId mount blade ', $this->stepId);--}}
        {{--        @endphp--}}


            @switch($stepId)
                @case(1)
                    <h1>comp 1</h1>
                    <livewire:form-step-1 :jsonQuestion="$jsonQuestion" :stepId="$stepId"/>
                    @break
                @case(2)
                    <h1>comp 2</h1>
                    <livewire:form-step-2 :jsonQuestion="$jsonQuestion" :stepId="$stepId"/>
                    @break
                @case(3)
                    <h1>comp 3</h1>
                    <livewire:form-step-3 :jsonQuestion="$jsonQuestion" :stepId="$stepId"/>
                    @break

                @default
                    <h1>comp 1</h1>
                    <livewire:form-step-1 :jsonQuestion="$jsonQuestion" :stepId="$stepId"/>
                @break
            @endswitch
    </div>

</div>
