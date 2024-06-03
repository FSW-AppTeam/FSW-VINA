@section('modal-body-select-list')
    <input class="form-control" list="datalistOptions" id="countryDataList"
           @if(isset($countryModal)) wire:model="countryModal" @endif
           placeholder="Type om te zoeken..." />
    <label for="datalistOptions">
        <datalist id="datalistOptions">
            @foreach(getIsoCountries() as $country)
                <option value="{{$country[0]}}">{{$country[0]}}</option>
            @endforeach
        </datalist>
    </label>
@endsection
