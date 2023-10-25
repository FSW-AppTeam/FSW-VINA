<div class="">
    <div class="">
{{--        <div class=" col-sm-12 col-md-9 col-lg-8 col-xl-7 col-xxl-4">--}}
            {{--    <h1>LAYOUT slot</h1>--}}

            <form method="POST" wire:submit.prevent="save">
                @csrf

                <div class="card @if($stepId === 0) animate__animated animate__fadeIn animate__slow @endif">
{{--                    <div class="card-header">{{ ucfirst($jsonQuestion->question_title) }}</div>--}}
                    <div class="card-body">

                        @if ($errors->getMessages())
                            <div class="step-notification alert alert-danger text-center">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div>
                            {{ $slot }}
                        </div>
                    </div>

                    @livewire('partials.form-buttons', ['stepId' => $stepId])
                </div>
            </form>

{{--        </div>--}}
    </div>
</div>

