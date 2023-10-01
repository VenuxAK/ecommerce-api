<?php

namespace App\Helpers;

trait HttpResponse
{
    use HttpStatusConverter;

    protected function success($data = [], $code = 200, $name = "data")
    {
        return response()->json([
            "status_code" => $code,
            "status_text" => $this->codeToText($code),
            $name => $data
        ], $code);
    }

    protected function responseStatus($code)
    {
        return response()->json([
            "status_code" => $code,
            "status_text" => $this->codeToText($code),
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
