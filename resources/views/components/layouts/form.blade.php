<div>
    <h1>LAYOUT slot</h1>

{{--    <div>--}}
{{--                @php--}}
{{--                    dump(Session::all());--}}
{{--                @endphp--}}
        <form method="POST"  wire:submit="save">
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

                    {{ $slot }}

                </div>

                @livewire('forms.form-buttons', ['stepId' => $stepId])

            </div>
        </form>
    </div>

</div>
