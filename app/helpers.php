<?php

if (!function_exists('response_data')) {
    function response_data($success, $message)
    {
        return json_encode([
            'success' => $success,
            'message' => $message
        ]);
    }
}