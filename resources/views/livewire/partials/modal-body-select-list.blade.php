@section('modal-body-select-list')
    <input class="form-control" list="datalistOptions" id="countryDataList" placeholder="Type om te zoeken..." />
    <label for="datalistOptions">
        <datalist id="datalistOptions">
            @foreach(getIsoCountries() as $country)
                <option value="{{$country[0]}}">{{$country[0]}}</option>
            @endforeach
        </datalist>
    </label>

@endsection
