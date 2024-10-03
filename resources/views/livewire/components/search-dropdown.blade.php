<div class="container">
    <div class="select">
        <input wire:model.live="search" id="searchCountry" type="text" placeholder="Zoek..." class="form-control">
        <br>
        @if (count($searchResults) > 0)
            <select  wire:model.live="selectedCountry" required
                     onSelect=Event.preventDefault() wire:key="{{ $selectedCountry }}" class="form-select" aria-label="Default select example">
                <option selected value="">Selecteer een land</option>
                @foreach ($searchResults as $country)
                    <option value="{{ $country[1] }}">{{ $country[1] }}</option>
                @endforeach
            </select>
        @else
            <div class="dropdown-item">No results for "{{ $search }}"</div>
        @endif
    </div>
</div>