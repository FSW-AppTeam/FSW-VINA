<div>
    <div>
        @php
            dump(Session::all());
        @endphp

        <form method="POST" name="form3" wire:submit="save">
            @csrf

            <div class="card">
                <div class="card-header">{{ ucfirst($jsonQuestion->question_title)  }}</div>

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

                        <div for="student-name" class="pb-1 col-10 text-center">{{ $jsonQuestion->question_content }}</div>
                    <div class="form-group">

                        <div class="d-flex flex-row p-5">
                            @livewire('students')
                        </div>

                        <div class="active-student p-2" id="active-student"></div>

                        <div class="col border-end d-flex justify-content-center align-items-center row">
                            @foreach ($jsonQuestion->question_answer as $index => $answer)
                                <button type="button" class="btn btn-secondary" style="width: 100%;margin: 10px" id="{{ $index }}">{{ $answer }}</button>
                            @endforeach
                        </div>

                    </div>
                </div>

                @livewire('forms.form-buttons', ['stepId' => $stepId])

            </div>
        </form>

    </div>
</div>



