<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    <div  wire:id="child-component-{{ $stepId }}">
        @php
            dump(Session::all());
        @endphp

        <form method="POST" name="form1" wire:submit="save" :jsonQuestion="$jsonQuestion">
            @csrf

            <div class="card">
                <div class="card-header">{{ $jsonQuestion->question_title }}</div>
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

                        @yield('form-input')

                </div>

                <div class="card-footer">
                    @if($stepId != 1)
                        <button class="btn btn-secondary float-start" name="form1"><-</button>
                    @endif
                    <button class="btn btn-secondary float-end" name="form1">-></button>
                </div>


                {{--            <div wire:loading>--}}
                {{--                <svg>...</svg> <!-- SVG loading spinner -->--}}
                {{--            </div>--}}

            </div>
        </form>
    </div>

    {{--  <button wire:click="$parent.setStepIdUp()">Parent stepid Up </button>--}}

</div>
