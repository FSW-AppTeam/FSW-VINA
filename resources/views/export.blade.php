@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Beheer {{ __('download') }}</div>
                    @foreach($files as $file)
                        <div class="row justify-content-center">
                            <div class="col-md-6">

                                @livewire('download', ['file' => $file])
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
