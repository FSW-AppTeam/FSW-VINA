<div>
    <div>
        @php
            dump(Session::all());
        @endphp

        <form method="POST" name="form3" wire:submit="save">
            @csrf

            <div class="card">
                <div class="card-header">{{ $jsonQuestion->question_title }}</div>

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
                        <p>{{ $jsonQuestion->question_content }}</p>



                        <div class="d-flex flex-row text-center">
                            @livewire('students')
{{--                            @foreach ($jsonQuestion->students as $student)--}}
{{--                                <div class="p-2" style="margin-right: 1rem" id="{{ $student['id'] }}">{{ $student['name'] }}</div>--}}
{{--                            @endforeach--}}
                        </div>

                        <div class="active-student" id="">Henk M</div>

                        <div class="col border-end d-flex justify-content-center align-items-center row">
                            @foreach ($jsonQuestion->question_answer as $index => $answer)
                                <button type="button" class="btn btn-secondary" style="width: 100%;margin: 10px" id="{{ $index }}">{{ $answer }}</button>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    @if($stepId != 1)
                        <button class="btn btn-secondary float-start" name="form3" wire:click="$parent.setStepIdDown()"><-</button>
                    @endif
                    <button class="btn btn-secondary float-end" name="form3">-></button>
                </div>

            </div>
        </form>

    </div>
</div>




