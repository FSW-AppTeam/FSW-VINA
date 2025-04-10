<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('translations')->delete();
        
        \DB::table('translations')->insert(array (
            0 => 
            array (
                'slug' => 'form.step_intro',
            'nl' => '        <h5>Hartelijk welkom bij de vragenlijst!</h5>          <p class="lh-sm mt-3">Het invullen van deze vragenlijst duurt ongeveer 20 minuten.</p>          <p class="lh-sm">In de informatiebrief kon je lezen waar het onderzoek over gaat, dat jouw antwoorden anoniem zijn en op een beveiligde plek worden opgeslagen. Als je een vraag liever niet invult mag je deze overslaan. Je mag ook op elk moment stoppen met de vragenlijst.</p>         <p class="lh-sm">Heb je een vraag of opmerking over het onderzoek? Dan kun je de onderzoekers mailen: zieelkaar@uu.nl.</p>          <p class="mb-1"><b>Door hieronder op de pijl te klikken, ga je akkoord met het volgende:</b></p>          <div class="px-2">             <ul>                 <li><span>Ik heb informatie over het onderzoek gehad.</span></li>                 <li><span>Ik heb de schriftelijke informatie gelezen en begrepen.</span></li>                 <li><span>Ik heb vragen kunnen stellen en ik heb antwoord gekregen. Ik heb genoeg tijd gehad om te bedenken of ik mee wilde doen en mijn deelname is vrijwillig.</span></li>                 <li><span>Ik weet dat er gegevens over mij worden verzameld.</span></li>                 <li><span>Ik ga akkoord met dat mijn antwoord op de vraag bij welke cultuur ik hoor, wordt gebruikt in de vragenlijst van mijn klasgenoten.</span></li>                 <li><span>Ik ga ermee akkoord dat die gegevens worden gebruikt wetenschappelijk onderzoek, zoals is uitgelegd in de informatiebrief.</span></li>                 <li><span>Ik ga ermee akkoord dat andere onderzoekers mijn anonieme gegevens gebruiken voor hun eigen onderzoek naar (de kijk van mensen op) culturele achtergrond en wat de gevolgen hiervan zijn.</span></li>             </ul>         </div>',
            'en' => '        <h5>ENGELS</h5>          <p class="lh-sm mt-3">Het invullen van deze vragenlijst duurt ongeveer 20 minuten.</p>          <p class="lh-sm">In de informatiebrief kon je lezen waar het onderzoek over gaat, dat jouw antwoorden anoniem zijn en op een beveiligde plek worden opgeslagen. Als je een vraag liever niet invult mag je deze overslaan. Je mag ook op elk moment stoppen met de vragenlijst.</p>         <p class="lh-sm">Heb je een vraag of opmerking over het onderzoek? Dan kun je de onderzoekers mailen: zieelkaar@uu.nl.</p>          <p class="mb-1"><b>Door hieronder op de pijl te klikken, ga je akkoord met het volgende:</b></p>          <div class="px-2">             <ul>                 <li><span>Ik heb informatie over het onderzoek gehad.</span></li>                 <li><span>Ik heb de schriftelijke informatie gelezen en begrepen.</span></li>                 <li><span>Ik heb vragen kunnen stellen en ik heb antwoord gekregen. Ik heb genoeg tijd gehad om te bedenken of ik mee wilde doen en mijn deelname is vrijwillig.</span></li>                 <li><span>Ik weet dat er gegevens over mij worden verzameld.</span></li>                 <li><span>Ik ga akkoord met dat mijn antwoord op de vraag bij welke cultuur ik hoor, wordt gebruikt in de vragenlijst van mijn klasgenoten.</span></li>                 <li><span>Ik ga ermee akkoord dat die gegevens worden gebruikt wetenschappelijk onderzoek, zoals is uitgelegd in de informatiebrief.</span></li>                 <li><span>Ik ga ermee akkoord dat andere onderzoekers mijn anonieme gegevens gebruiken voor hun eigen onderzoek naar (de kijk van mensen op) culturele achtergrond en wat de gevolgen hiervan zijn.</span></li>             </ul>         </div>',
            ),
            1 => 
            array (
                'slug' => 'form.step_seven_country_of_origin',
                'nl' => 'step_seven_country_of_origin',
                'en' => 'step_seven_country_of_origin',
            ),
            2 => 
            array (
                'slug' => 'form.step_two',
                'nl' => 'Je achternaam is niet nodig. Als iemand in je klas dezelfde voornaam heeft als jij, dan kun je de eerste letter van je achternaam toevoegen.',
                'en' => 'step_two',
            ),
            3 => 
            array (
                'slug' => 'form.step_two_note',
                'nl' => '       <span style="text-decoration: underline">Let op!</span> Je moet je naam invullen zodat je                 klasgenoten ook vragen over jou kunnen beantwoorden. Je naam wordt na afloop van dit onderzoek verwijderd.',
                'en' => 'step_two_note',
            ),
        ));
        
        
    }
}