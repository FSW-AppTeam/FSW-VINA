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
                'nl' => '<h5>Welkom!</h5> <br><br><p class="lh-sm mt-3">U bent uitgenodigd om deel te nemen aan een onderzoek naar hoe mensen kijken naar verschillende culturele groepen in Nederland. <br><br>In deze vragenlijst zullen we eerst wat vragen stellen over uw achtergrond, daarna zullen we u onder andere vragen stellen over mensen in uw sociale omgeving en hoe u hen ziet. Daarna wordt gevraagd naar uw houding ten aanzien van verschillende groepen in Nederland. Ook zijn we benieuwd naar uw mening over de economische ongelijkheid in Nederland en wat hieraan zou moeten gebeuren. <br><br>De vragenlijst duurt ongeveer 8 minuten. Uw antwoorden worden natuurlijk anoniem verwerkt en strikt vertrouwelijk behandeld. Er zal gevraagd worden naar de voornamen van mensen in uw sociale omgeving. Deze namen worden direct verwijderd als alle data is verzameld. Sommige vragen kunnen wat gevoelig liggen: er worden onderwerpen aangekaart waarover veel discussie bestaat. De vragenlijst gaat echter over uw persoonlijke mening en situatie. Daarnaast zal u worden gevraagd naar uw culturele achtergrond, opleidingsniveau en werk omdat dit soort factoren kunnen samenhangen met uw houdingen. Bovendien mag u vragen overslaan als u die liever niet invult en kunt u op elk moment stoppen met de vragenlijst zonder een reden te hoeven geven. <br><br>Uw gegevens en antwoorden worden alleen gebruikt voor analyses en eventuele publicatie in wetenschappelijke tijdschriften. Aan het einde van het onderzoeksproject zal de geanonimiseerde data openbaar beschikbaar worden gesteld, zodat ook andere onderzoekers er gebruik van kunnen maken. De informatie die u geeft zal niet te herleiden zijn naar u als individu. De gegevens worden voor 10 jaar opgeslagen door de faculteit Sociale Wetenschappen van de Universiteit Utrecht. Hiermee werken we in overeenstemming met het beleid van de Universiteit Utrecht. Als u hier vragen over hebt, dan kunt u contact opnemen met de functionaris gegevensbescherming van de Universiteit Utrecht via privacy@uu.nl. Als u een klacht heeft over het onderzoek, kunt u contact opnemen met de ethische toetsingscommissie van de Faculteit Sociale Wetenschappen van de Universiteit Utrecht: klachtenfunctionaris-fetcsocwet@uu.nl <br><br>Het invullen van deze vragenlijst brengt geen noemenswaardige risico’s of ongemakken met zich mee en u zult niet geconfronteerd worden met aanstootgevende of beledigende informatie. <br><br>Voor vragen of opmerkingen over de inhoud van de vragenlijst kunt u contact opnemen met dr. Tobias Stark, de projectleider: t.h.stark@uu.nl. Voor onafhankelijk advies over dit onderzoek kunt u ook terecht bij Marcel Lubbers (m.lubbers@uu.nl). Hij kent de achtergrond van het onderzoek, maar heeft hier verder niets mee te maken. <br><br><strong>Door hieronder op “verder” te klikken gaat u akkoord met het volgende:</strong> <br><br> Ik ben duidelijk geïnformeerd over het onderzoek. Ik weet wie ik kan benaderen om vragen te stellen over het onderzoek. Ik heb de gelegenheid gekregen om over mijn deelname aan het onderzoek na te denken en mijn deelname is geheel vrijwillig. Ik stem in met het gebruik van mijn antwoorden voor wetenschappelijk onderzoek en dat mijn geanonimiseerde gegevens openbaar beschikbaar kunnen worden gesteld.</p>',
                'en' => "<h5>Welcome!</h5><p class=\"lh-sm mt-3\"> You are invited to participate in a study on how people perceive different cultural groups in the Netherlands. <br><br>In this questionnaire, we will first ask you some questions about your background. We will then ask you, among other things, about people in your social environment and how you perceive them. Next, we will ask about your attitudes toward different groups in the Netherlands. We are also interested in your views on economic inequality in the Netherlands and what should be done about it. <br><br>The questionnaire takes approximately 8 minutes to complete. Your responses will, of course, be processed anonymously and treated with strict confidentiality. You will be asked to provide the first names of people in your social environment. These names will be deleted as soon as all the data has been collected. Some questions may touch on sensitive issues, as they address topics that are the subject of considerable debate. However, the questionnaire concerns your personal opinions and circumstances. You will also be asked about your cultural background, level of education, and employment, as these factors may be associated with people's attitudes. In addition, you may skip any questions you would prefer not to answer, and you may stop completing the questionnaire at any time without having to give a reason. <br><br>Your data and responses will be used solely for analyses and possible publication in scientific journals. At the end of the research project, the anonymized data will be made publicly available so that other researchers can also use it. The information you provide cannot be traced back to you as an individual. The data will be stored for 10 years by the Faculty of Social and Behavioural Sciences at Utrecht University. In doing so, we comply with Utrecht University's policies. If you have any questions about this, you can contact Utrecht University's Data Protection Officer at privacy@uu.nl. If you have a complaint about the study, you can contact the ethics review committee of the Faculty of Social and Behavioural Sciences at Utrecht University at klachtenfunctionaris-fetcsocwet@uu.nl <br><br>Completing this questionnaire does not involve any significant risks or discomfort, and you will not be exposed to offensive or insulting information. <br><br>If you have any questions or comments about the content of the questionnaire, you can contact Dr. Tobias Stark, the project leader, at t.h.stark@uu.nl. For independent advice about this study, you can also contact Marcel Lubbers at m.lubbers@uu.nl. He is familiar with the background of the study but is otherwise not involved in it. <br><br><strong/>By clicking “Continue” below, you agree to the following: </strong><br><br>I have been clearly informed about the study. I know whom I can contact if I have questions about the study. I have been given the opportunity to consider my participation, and my participation is entirely voluntary. I consent to the use of my responses for scientific research and to my anonymized data being made publicly available.</p>",
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
