{{--<div>--}}
{{--    <div>--}}
{{--        @php--}}
{{--            dump(Session::all());--}}
{{--        @endphp--}}


{{--        <form method="POST" wire:submit="save">--}}

{{--            <h3>{{ $json->question_content }}</h3>--}}

{{--            <div class="mt-4">--}}
{{--                <label for="body2" class="block font-medium text-sm text-gray-700">Body22222222</label>--}}
{{--                <textarea id="body2" wire:model="body2"--}}
{{--                          class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"></textarea>--}}

{{--                @error('body2')--}}
{{--                <span class="mt-2 text-sm text-red-600">{{ $message }}</span>--}}
{{--                @enderror--}}
{{--            </div>--}}

{{--            <button--}}
{{--                class="mt-4 px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">--}}
{{--                Save 2 form--}}
{{--            </button>--}}
{{--        </form>--}}


{{--        <hr />--}}
{{--        <button wire:click="$parent.setStepIdDown()">Parent back </button>--}}
{{--        <button wire:click="$parent.setStepIdUp()">Parent stepid Up </button>--}}
{{--    </div>--}}
{{--</div>--}}


@extends('layouts.form')

@section('form-input')
    <div wire:id="child-component-{{ $componentId }}">

    </div>

{{--<h3>{{ $jsonQuestion->question_content }}</h3>--}}

{{--<div class="mt-4">--}}
{{--    <label for="body2" class="block font-medium text-sm text-gray-700">Body22222222</label>--}}
{{--    <textarea id="body2" wire:model="body2"--}}
{{--              class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"></textarea>--}}

{{--    @error('body2')--}}
{{--    <span class="mt-2 text-sm text-red-600">{{ $message }}</span>--}}
{{--    @enderror--}}
{{--</div>--}}

@endsection
