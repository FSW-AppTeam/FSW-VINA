<x-layouts.form
    :step-id="$stepId"
    :loading="$loading"
    :json-question="$jsonQuestion">
    <div class="">
        <h5>Hartelijk welkom bij de vragenlijst!</h5>

        <p class="lh-sm mt-3">Het invullen van deze vragenlijst duurt ongeveer 20 minuten.</p>

        <p class="lh-sm">In de informatiebrief heb je kunnen lezen waar het onderzoek over gaat en dat jouw antwoorden uiteraard anoniem worden verwerkt en strikt vertrouwelijk worden behandeld. Bovendien mag je elke vraag onbeantwoord laten als je die liever niet invult. Je mag ook op elk moment stoppen met de vragenlijst.</p>
        <p class="lh-sm">Voor vragen of opmerkingen over deze vragenlijst kunt je contact opnemen met het projectteam via zieelkaar@uu.nl.</p>

        <p class="mb-1"><b>Door hieronder op de pijl te klikken ga je akkoord met het volgende:</b></p>

        <div class="px-2">
            <ul>
                <li><span>Ik ben geïnformeerd over het onderzoek.</span></li>
                <li><span>Ik heb de schriftelijke informatie gelezen en begrepen.</span></li>
                <li><span>Ik weet wie ik kan benaderen om benaderen om vragen te stellen over het onderzoek.</span></li>
                <li><span>Ik heb de gelegenheid gekregen om over mijn deelname aan het onderzoek na te denken en mijn deelname is geheel vrijwillig.</span></li>
                <li><span>Ik stem in met dat de antwoorden die ik geef op de vraag bij welke cultuur ik hoor, ook worden gebruikt om mijn klasgenoten naar mijn cultuur te vragen.</span></li>
                <li><span>Ik stem in met het gebruik van mijn antwoorden voor wetenschappelijk onderzoek.</span></li>
            </ul>
        </div>
    </div>
</x-layouts.form>
