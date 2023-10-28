<?php

use Illuminate\Support\Facades\Lang;

if (!function_exists('_api_json')) {

    function _api_json($data = NULL, $extra_params = array(), $http_code = 200) {
        $json = array();
        $json['data'] = $data;
        if (!empty($extra_params)) {
            foreach ($extra_params as $key => $param) {
                $json[$key] = $param;
            }
        }
        if (isset($json['errors'])) {
            foreach ($json['errors'] as $key => $error) {
                $json['errors'][$key] = $error[0];
            }
        }
        return response()->json($json, $http_code, []);
    }
}

if (!function_exists('_lang')) {

    function _lang($item) {
        if (Lang::has($item)) {
            $line = Lang::get($item);
        } else {
            $item_arr = explode('.', $item);
            array_shift($item_arr);
            $line = end($item_arr);
            $line = str_replace('_', ' ', ucwords($line));
        }

        return $line;
    }
}
