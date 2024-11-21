<?php

class Utf8Convert {

    public static function utf8_convert($data) {
        if (is_array($data)) {
            return array_map(array('Utf8Convert', 'utf8_convert'), $data);
        } elseif (is_object($data)) {
            foreach ($data as $key => $value) {
                $data->$key = self::utf8_convert($value);
            }
            return $data;
        } else {
            // Detectar y convertir solo si no está en UTF-8
            if (is_string($data)) {
                $encoding = mb_detect_encoding($data, 'UTF-8, ISO-8859-1, ISO-8859-15', true);
                if ($encoding !== 'UTF-8' && $encoding !== false) {
                    return iconv($encoding, 'UTF-8//TRANSLIT', $data);
                }
                return $data;
            }
            return $data;
        }
    }

}
