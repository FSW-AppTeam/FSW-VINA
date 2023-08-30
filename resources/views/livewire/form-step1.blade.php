<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    <div>
        @php
            dump(Session::all());
        @endphp
        <form method="POST" name="form1" wire:submit="save">
            @csrf

            <div class="card">
                <div class="card-header">{{ ucfirst($jsonQuestion->question_title) }}</div>
                <div class="card-body pb-5">
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
                        <label for="student-class-code" class="pb-1">{{ $jsonQuestion->question_content }}</label>
                        <input type="text" wire:model="classId" class="form-control" name="student-class-code">
                    </div>

                    @error('student-class-code')
                    <span class="mt-2 text-sm text-red-600">{{ $message }}</span>
                    @enderror

                </div>

                <div class="card-footer">
                    @if($stepId != 1)
                        <input class="btn btn-secondary float-start" wire:click="$parent.setStepIdDown()" type="button" value="<-" name="back-btn"/>
                    @endif
                    <button class="btn btn-secondary float-end">-></button>
                </div>


                {{--            <div wire:loading>--}}
                {{--                <svg>...</svg> <!-- SVG loading spinner -->--}}
                {{--            </div>--}}

            </div>
        </form>
    </div>

    {{--  <button wire:click="$parent.setStepIdUp()">Parent stepid Up </button>--}}

</div>
