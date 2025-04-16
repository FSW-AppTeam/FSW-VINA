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

        \DB::table('translations')->insert([
            0 => [
                'slug' => 'form.step_intro',
                'nl' => '<h5>Hartelijk welkom bij de vragenlijst!</h5><p class="lh-sm mt-3">Het invullen van deze vragenlijst duurt ongeveer 20 minuten.</p><p class="lh-sm">In de informatiebrief kon je lezen waar het onderzoek over gaat, dat jouw antwoorden anoniem zijn en op een beveiligde plek worden opgeslagen. Als je een vraag liever niet invult mag je deze overslaan. Je mag ook op elk moment stoppen met de vragenlijst.</p><p class="lh-sm">Heb je een vraag of opmerking over het onderzoek? Dan kun je de onderzoekers mailen: zieelkaar@uu.nl.</p><p class="mb-1"><b>Door hieronder op de pijl te klikken, ga je akkoord met het volgende:</b></p><div class="px-2"><ul><li><span>Ik heb informatie over het onderzoek gehad.</span></li><li><span>Ik heb de schriftelijke informatie gelezen en begrepen.</span></li><li><span>Ik heb vragen kunnen stellen en ik heb antwoord gekregen. Ik heb genoeg tijd gehad om te bedenken of ik mee wilde doen en mijn deelname is vrijwillig.</span></li><li><span>Ik weet dat er gegevens over mij worden verzameld.</span></li><li><span>Ik ga akkoord met dat mijn antwoord op de vraag bij welke cultuur ik hoor, wordt gebruikt in de vragenlijst van mijn klasgenoten.</span></li><li><span>Ik ga ermee akkoord dat die gegevens worden gebruikt wetenschappelijk onderzoek, zoals is uitgelegd in de informatiebrief.</span></li><li><span>Ik ga ermee akkoord dat andere onderzoekers mijn anonieme gegevens gebruiken voor hun eigen onderzoek naar (de kijk van mensen op) culturele achtergrond en wat de gevolgen hiervan zijn.</span></li></ul></div>',
                'en' => '<h5>Welcome to this survey!</h5><p class="lh-sm mt-3">By clicking the arrow below, you agree to participate in this research.</p>    ',
            ],
            1 => [
                'slug' => 'form.step_seven_country_of_origin',
                'nl' => 'step_seven_country_of_origin',
                'en' => 'step_seven_country_of_origin',
            ],
            2 => [
                'slug' => 'form.step_two',
                'nl' => 'Je achternaam is niet nodig. Als iemand in je klas dezelfde voornaam heeft als jij, dan kun je de eerste letter van je achternaam toevoegen.',
                'en' => 'Your last name is not required. If someone in your network has the same first name as you, you can add the first letter of your last name',
            ],
            3 => [
                'slug' => 'form.step_two_note',
                'nl' => '<span style="text-decoration: underline">Let op!</span> Je moet je naam invullen zodat je klasgenoten ook vragen over jou kunnen beantwoorden. Je naam wordt na afloop van dit onderzoek verwijderd.',
                'en' => '<span style="text-decoration: underline">Take note!</span> You have to fill in your name, so other students can respond on questions about you. Your name will be removed after the survey.',
            ],
            4 => [
                'slug' => 'nav.signed_in_as',
                'nl' => 'signed_in_as',
                'en' => 'signed_in_as',
            ],
            5 => [
                'slug' => 'nav.role_description',
                'nl' => 'role_description',
                'en' => 'role_description',
            ],
            6 => [
                'slug' => 'user.admin',
                'nl' => 'admin',
                'en' => 'admin',
            ],
            7 => [
                'slug' => 'nav.login',
                'nl' => 'login',
                'en' => 'login',
            ],
            8 => [
                'slug' => 'nav.surveyanswerstable',
                'nl' => 'Antwoorden',
                'en' => 'Responses',
            ],
            9 => [
                'slug' => 'nav.usertable',
                'nl' => 'Gebruikers',
                'en' => 'Users',
            ],
            10 => [
                'slug' => 'nav.roletable',
                'nl' => 'Rollen',
                'en' => 'Roles',
            ],
            11 => [
                'slug' => 'nav.surveyquestiontable',
                'nl' => 'Vragen',
                'en' => 'Questions',
            ],
            12 => [
                'slug' => 'nav.surveytable',
                'nl' => 'Afnames',
                'en' => 'Surveys',
            ],
            13 => [
                'slug' => 'nav.surveystudenttable',
                'nl' => 'Participanten',
                'en' => 'Participants',
            ],
            14 => [
                'slug' => 'nav.translationtable',
                'nl' => 'Vertalingen',
                'en' => 'Translations',
            ],
            15 => [
                'slug' => 'nav.settingtable',
                'nl' => 'Instellingen',
                'en' => 'Settings',
            ],
            16 => [
                'slug' => 'nav.install_questions',
                'nl' => 'Installeer vragen',
                'en' => 'Install questions',
            ],
            17 => [
                'slug' => 'nav.csv-export-list',
                'nl' => 'csv-export-list',
                'en' => 'csv-export-list',
            ],
            18 => [
                'slug' => 'nav.permissions',
                'nl' => 'permissions',
                'en' => 'permissions',
            ],
            19 => [
                'slug' => 'nav.signout',
                'nl' => 'signout',
                'en' => 'signout',
            ],
            20 => [
                'slug' => 'lang.en',
                'nl' => 'en',
                'en' => 'en',
            ],
            21 => [
                'slug' => 'lang.nl',
                'nl' => 'nl',
                'en' => 'nl',
            ],
            22 => [
                'slug' => 'app.download',
                'nl' => 'download',
                'en' => 'download',
            ],
            23 => [
                'slug' => 'app.Dashboard',
                'nl' => 'Dashboard',
                'en' => 'Dashboard',
            ],
            24 => [
                'slug' => 'app.You are logged in!',
                'nl' => 'Je bent ingelogd!',
                'en' => 'You are logged in!',
            ],
            25 => [
                'slug' => 'app.install_question_set',
                'nl' => 'Installeer vragen set',
                'en' => 'Install question set',
            ],
            26 => [
                'slug' => 'app.install_question_set_instruction',
                'nl' => 'Je kunt alleen een vragenset installeren als er geen survey meer in het systeem staan. Deze moet je eerst verwijderen. Let op! als je surveys verwijderd verwijder je ook alle participant data.',
                'en' => 'You can only install a question set when all surveys are removed. So remove them before you install a question set. When you remove a survey, all participants data will be removed as well.',
            ],
        ]);

    }
}
