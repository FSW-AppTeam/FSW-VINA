<?php

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

//if (! function_exists('compareVariables')) {
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
//}
