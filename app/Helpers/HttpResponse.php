<?php

namespace App\Helpers;

trait HttpResponse
{
    use HttpStatusConverter;

    protected function success($data = [], $code = 200)
    {
        return response()->json([
            "status_code" => $code,
            "status_text" => $this->codeToText($code),
            "data" => $data
        ], $code);
    }

    protected function failed($errors, $code)
    {
        return response()->json([
            "status_code" => $code,
            "status_text" => $this->codeToText($code),
            "messages" => $errors
        ], $code);
    }
}
