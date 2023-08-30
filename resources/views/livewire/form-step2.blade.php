<div>
    <div>
        @php
            dump(Session::all());
        @endphp

        <form method="POST" name="form2" wire:submit="save">
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
                        <label for="student-name" class="pb-1">{{ $jsonQuestion->question_content }}</label>
                        <input type="text" wire:model="name" class="form-control" name="">

                        <br />
                        <p>
                            {{ $jsonQuestion->question_options->extra_text }}
                        </p>
                    </div>
                </div>

                <div class="card-footer">
                    @if($stepId != 1)
                        <button class="btn btn-secondary float-start" name="form2" wire:click="$parent.setStepIdDown()"><-</button>
                    @endif
                    <button class="btn btn-secondary float-end" name="form2">-></button>
                </div>

            </div>
        </form>


{{--        <button wire:click="$parent.setStepIdDown()">Parent back </button>--}}
{{--        <button wire:click="$parent.setStepIdUp()">Parent stepid Up </button>--}}
    </div>
</div>




