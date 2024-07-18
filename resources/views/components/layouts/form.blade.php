<div class="">
    <div class="">
        <div class="card @if($stepId === 0) animate__animated animate__fadeIn animate__slow @endif">
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
            @livewire('partials.form-buttons', [
                'stepId' => $stepId,
                'jsonQuestion' => $jsonQuestion,
                'nextEnabled' => $nextEnabled,
                'backEnabled' => $backEnabled])
        </div>
    </div>
</div>

