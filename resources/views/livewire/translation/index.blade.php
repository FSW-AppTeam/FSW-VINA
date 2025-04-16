@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Translations</h3>
                @livewire('translation-table')
            </div>
        </div>
    </div>
@endsection
