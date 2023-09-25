<div>
{{--    <h1>LAYOUT slot</h1>--}}

    <form method="POST" wire:submit.prevent="save">
        @csrf

        <div class="card">
            <div class="card-header">{{ ucfirst($jsonQuestion->question_title) }}</div>
            <div class="card-body pb-5">

                @if ($errors->getMessages())
                    <div class="alert alert-danger p-2 text-center">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{ $slot }}

            </div>

            @livewire('forms.form-buttons', ['stepId' => $stepId])

        </div>
    </form>
</div>

