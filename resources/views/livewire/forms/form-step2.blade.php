<div>
    <div>
        @php
            dump(Session::all());
        @endphp

        <form method="POST" name="form2" wire:submit="save">
            @csrf

            <div class="card">
                <div class="card-header">{{ ucfirst($jsonQuestion->question_title) }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="student-name" class="pb-1">{{ $jsonQuestion->question_content }}</label>
                        <input type="text" wire:model="name" class="form-control" name="student-nam">

                        <br />
                        <p>
                            {{ $jsonQuestion->question_options->extra_text }}
                        </p>
                    </div>
                </div>

                @livewire('forms.form-buttons', ['stepId' => $stepId])

            </div>
        </form>

    </div>
</div>




