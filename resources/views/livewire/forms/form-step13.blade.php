<x-layouts.form :step-id="$stepId" :json-question="$jsonQuestion">
    <div>

        @if(count($flagsSelected) >= 4)
            <div class="step-notification alert alert-danger text-center">
                <p>{{ $jsonQuestion->question_options->error_text }}</p>
            </div>
        @endif

        <div class="set-fade-in">
            <div id="scope-form-step13">

                <h6 class="mt-2 text-center">{{ $jsonQuestion->question_content }}</h6>

                <div class=" text-center mt-4">
                    <div style="display: inline-flex">

                        @for($x = 0; $x <= 3; $x++)
                            @if(isset($flagsSelected[$x]))
                                {{--                        {{$flagsSelected[$x]['id']}}--}}

                                <img src="{{ asset('flags/'.$flagsSelected[$x]['image'].'.jpg') }}"
                                     style="height: 50px; width: 75px; margin: 5px; display: inline-block; box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 15px 0 rgba(0, 0, 0, 0.19);"
                                     type="button"
                                     wire:click="removeSelectedFlagId({{$flagsSelected[$x]['id'] }}, '{{$flagsSelected[$x]['country']}}')"
                                     id="{{$flagsSelected[$x]['id']}}"
                                     alt="{{$flagsSelected[$x]['image']}}"
                                     class="rounded">
                            @else
                                <div style="height: 45px; width: 75px; margin: 5px; background-color: #f8f8f8; display: inline-block;
                    border: 1px solid darkgray;box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 15px 0 rgba(0, 0, 0, 0.19);"
                                     class="rounded"></div>
                            @endif
                        @endfor
                    </div>

                </div>

                <div class="mt-2 mb-5 fst-italic text-center">{{ $jsonQuestion->question_options->extra_text }}</div>

                    <div class="row row-cols-2 justify-content-center text-center flags-row-buttons">
                        @foreach ($jsonQuestion->question_answer_options as $index => $answer)
                            <livewire:partials.flag-image :id="$answer->id"
                                                          :image="$answer->flag"
                                                          :country="ucfirst($answer->value)"
                                                          :flags-selected="$flagsSelected"
                                                          wire:key="flag-set-key-{{ $index . time() }}"/>
                        @endforeach
                </div>
            </div>
        </div>


        <div class="modal fade" id="countryModal" tabindex="-1" aria-labelledby="countryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered rounded">

                <div class="modal-content" style="height: 22rem;">
                    <div class="float-end">
                        <button type="button" class="float-end p-3 btn-close " data-bs-dismiss="modal"
                                aria-label="Sluit"></button>
                    </div>
                    <h5 class="modal-title text-center" id="countryModalLabel">Van welk land is die cultuur?</h5>

                    <div class="modal-body">
                        @include('livewire.partials.modal-body-select-list')
                        @yield('modal-body-select-list')

                        <div class="mt-5 p-5 text-center">
                            <button type="button" id="country-set-btn" disabled style="width:80%"
                                    class="btn btn-outline-warning mt-5">OK
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.form>



