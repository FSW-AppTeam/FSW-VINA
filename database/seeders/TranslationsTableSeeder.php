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
                'nl' => 'Welkom!<br><br>U bent uitgenodigd om deel te nemen aan een onderzoek naar hoe mensen kijken naar verschillende culturele groepen in Nederland.<br><br>In deze vragenlijst zullen we eerst wat vragen stellen over uw achtergrond, daarna zullen we u onder andere vragen stellen over mensen in uw sociale omgeving en hoe u hen ziet. Daarna wordt gevraagd naar uw houding ten aanzien van verschillende groepen in Nederland. Ook zijn benieuwd naar uw mening over de economische ongelijkheid in Nederland en wat hieraan zou moeten gebeuren.<br><br>De vragenlijst duurt ongeveer 8 minuten. Uw antwoorden worden uiteraard anoniem verwerkt en strikt vertrouwelijk behandeld. Er zal gevraagd worden naar de voornamen van mensen in uw sociale omgeving. Deze namen worden direct verwijderd als alle data is verzameld.<br><br>Sommige vragen kunnen wat gevoelig liggen: er worden onderwerpen aangekaart waarover veel discussie bestaat. De vragenlijst gaat echter over uw persoonlijke mening en situatie. Daarnaast zal u worden gevraagd naar uw culturele achtergrond, opleidingsniveau en politieke voorkeur omdat dit soort factoren kunnen samenhangen met uw houdingen.<br><br>Aan het eind van de vragenlijst wordt verder uitgelegd welke verwachtingen we willen toetsen met dit onderzoek. Bovendien mag u vragen overslaan als u die liever niet invult en kunt u op elk moment stoppen met de vragenlijst zonder een reden te hoeven geven.<br><br>Uw gegevens en antwoorden worden alleen gebruikt voor analyses en eventuele publicatie in wetenschappelijke tijdschriften. Aan het einde van het onderzoeksproject zal de geanonimiseerde data openbaar beschikbaar worden gesteld, zodat ook andere onderzoekers er gebruik van kunnen maken. De informatie die u geeft zal niet te herleiden zijn naar u als individu.<br><br>De gegevens worden voor 10 jaar opgeslagen door de faculteit Interdisciplinaire Sociale Wetenschap van de Universiteit Utrecht. Hiermee werken we in overeenstemming met het beleid van de Universiteit Utrecht.<br><br>Als u hier vragen over hebt, dan kunt u contact opnemen met de functionaris gegevensbescherming van de Universiteit Utrecht via privacy@uu.nl.<br><br>Als u een klacht heeft over het onderzoek, kunt u contact opnemen met de ethische toetsingscommissie van de Faculteit Sociale Wetenschappen van de Universiteit Utrecht via klachtenfunctionaris-fetcsocwet@uu.nl.<br><br>Het invullen van deze vragenlijst brengt geen noemenswaardige risico’s of ongemakken met zich mee en u zult niet geconfronteerd worden met aanstootgevende of beledigende informatie.<br><br>Voor vragen of opmerkingen over de inhoud van de vragenlijst kunt u contact opnemen met dr. Tobias Stark, de projectleider: t.h.stark@uu.nl.<br><br>Door hieronder op “verder” te klikken gaat u akkoord met het volgende:<br><br>Ik ben duidelijk geïnformeerd over het onderzoek. Ik weet wie ik kan benaderen om vragen te stellen over het onderzoek. Ik heb de gelegenheid gekregen om over mijn deelname aan het onderzoek na te denken en mijn deelname is geheel vrijwillig. Ik stem in met het gebruik van mijn antwoorden voor wetenschappelijk onderzoek en dat mijn geanonimiseerde gegevens openbaar beschikbaar kunnen worden gesteld',
                'en' => '<h5>Welcome!</h5><p class="lh-sm mt-3">You have been invited to take part in a survey on how people view different cultural groups in the Netherlands.<br><br>In this questionnaire, we will first ask you some questions about your background, then we will ask you, amongst other things, about people in your social circle and how you view them. We will then ask about your attitudes towards different groups in the Netherlands. We are also interested in your views on economic inequality in the Netherlands and what should be done about it.<br><br>The questionnaire will take approximately 8 minutes to complete. Your answers will, of course, be processed anonymously and treated as strictly confidential. You will be asked for the first names of people in your social circle. These names will be deleted immediately once all the data has been collected.<br><br>Some questions may be somewhat sensitive: topics are raised that are the subject of much debate. However, the questionnaire focuses on your personal views and circumstances. You will also be asked about your cultural background, level of education and political preferences, as these factors may be linked to your attitudes.<br><br>At the end of the questionnaire, there is a further explanation of the expectations we wish to test through this research. Furthermore, you may skip any questions you would rather not answer, and you may stop completing the questionnaire at any time without having to give a reason.<br><br>Your details and answers will only be used for analysis and possible publication in academic journals.</p>',
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
