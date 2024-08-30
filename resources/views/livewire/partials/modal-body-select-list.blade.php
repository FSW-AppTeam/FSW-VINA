@section('modal-body-select-list')
    <input class="form-control" list="datalistOptions" id="countryDataList"
    @if(isset($countryModal)) wire:model="countryModal" @endif
    placeholder="Type om te zoeken..." />
    <datalist id="datalistOptions">
        @foreach(getCountriesByIso() as $country)
            <option value="{{$country[1]}}">{{$country[1]}}</option>
        @endforeach
    </datalist>
@endsection
