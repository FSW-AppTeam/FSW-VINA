<?php

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;

if (! function_exists('getCountriesByIso')) {

    function getCountriesByIso()
    {
        $fileContents = file(storage_path('app/country_list.csv'));
        foreach ($fileContents as $line) {
            $tempLine = str_getcsv($line);
            $tempLine[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $tempLine[0]);
            $data[$tempLine[0]] = [
                $tempLine[0],
                $tempLine[1],
                $tempLine[2],
                $tempLine[3],
            ];
        }

        return $data;
    }
}

if (! function_exists('getCountriesByName')) {
    function getCountriesByName()
    {
        $fileContents = file(storage_path('app/country_list.csv'));

        foreach ($fileContents as $line) {
            $tempLine = str_getcsv($line);
            $tempLine[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $tempLine[0]);
            $data[$tempLine[1]] = [
                $tempLine[0],
                $tempLine[1],
                $tempLine[2],
                $tempLine[3],
            ];
        }

        return $data;
    }
}

if (! function_exists('setNationalityOptions')) {
    function setNationalityOptions($dependsOnQuestionId, $studentId = null)
    {
        if ($studentId == null) {
            $studentId = Session::get('student-id');
        }
        $savedAnswer = SurveyAnswer::where('question_id', $dependsOnQuestionId)
            ->where('student_id', $studentId)
            ->first();
        $dependsOnQuestion = SurveyQuestion::find($dependsOnQuestionId);
        if (! $savedAnswer) {
            return [];
        }
        foreach ($dependsOnQuestion->question_answer_options as $option) {
            if ($option['id'] == $savedAnswer->student_answer['country_id']) {
                $otherCountry = $option['value'];
            }
        }
        switch ($savedAnswer->student_answer['country_id']) {
            case 1:
                break;
            case 2:
            case 3:
            case 4:
                return getCountriesByName()[$otherCountry];
            case 5:
                return getCountriesByName()['Nederlandse Antillen'];
            case 6:
                return getCountriesByName()[$savedAnswer->student_answer['other_country']];
                //            default:
                //                return [];
        }

        return [];
    }
}

if (! function_exists('csvToArray')) {
    function csvToArray($filename = '', $headers = null, $delimiter = ';')
    {
        if (! file_exists($filename) || ! is_readable($filename)) {
            return false;
        }

        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            $headerSet = false;
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (empty($headers) && ! $headerSet) {
                    $headers = $row;
                    $headerSet = true;

                    continue;
                }
                $data[] = array_combine($headers, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}

if (! function_exists('get_flag_for_locale')) {
    function get_flag_for_locale($locale): string
    {
        switch ($locale) {
            case 'en':
                return 'gb';
            case 'nl':
                return 'nl';
            case 'fr':
                return 'fr';
            default:
                return 'sr';
        }
    }
}

if (! function_exists('printWithQuestionOptions')) {
    function printWithQuestionOptions($text, $replace, $key = null): string
    {
        if (is_array($replace) && isset($replace[$key])) {
            $replace = $replace[$key];
        }
        if (empty($replace)) {
            $replace = '';
        }
        return str_replace(':questionOptions', $replace, $text);
    }
}

if (! function_exists('echoArray')) {
    function echoArray($text): string
    {
        $print = '';
        if (! is_array($text)) {

            return $print;

            return $text;
        }

        foreach ($text as $line) {
            $print .= $line.'<br>';
        }

        return $print;
    }
}

if (! function_exists('langDatabase')) {
    /**
     * Translate the given message.
     *
     * @param  string|null  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return string|array|null
     */
    function langDatabase($key = null, $replace = [], $locale = null)
    {
        if (is_null($key)) {
            return $key;
        }

        $locale = \App\Models\Setting::where('key', 'locale')->first()->value;
        if ($locale) {
            app()->setLocale($locale);
        }
        $locale = app()->getLocale();
        $translation = \App\Models\Translation::where('slug', $key)->whereNotNull($locale)->first();

        if ($translation) {
            app('translator')->addLines([$key => $translation->$locale], $locale);
        }
        if (app('translator')->has($key)) {
            return trans($key, $replace, $locale);
        }

        return $key;
    }

}

// if (! function_exists('compareVariables')) {
//    function compareVariables($value1, $operator, $value2): string
//    {
//        switch ($operator) {
//            case '<':
//                return $value1 < $value2;
//            case '<=':
//                return $value1 <= $value2;
//            case '>':
//                return $value1 > $value2;
//            case '>=':
//                return $value1 >= $value2;
//            case '==':
//                return $value1 == $value2;
//            case '!=':
//                return $value1 != $value2;
//            default:
//                return false;
//        }
//    }
// }
