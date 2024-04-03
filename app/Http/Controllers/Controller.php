<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function statusCode(int $code, $content = null): Response
    {
        return response($content, $code);
    }

    protected function ok($content = null): Response
    {
        return $this->statusCode(200, $content);
    }

    protected function created($content = null): Response
    {
        return $this->statusCode(201, $content);
    }

    protected function noContent(): Response
    {
        return $this->statusCode(204);
    }

    protected function badRequest($content = null): Response
    {
        return $this->statusCode(400, $content);
    }

    protected function unauthorized($content = null): Response
    {
        return $this->statusCode(401, $content);
    }

    protected function forbidden($content = null): Response
    {
        return $this->statusCode(403, $content);
    }

    protected function notFound($content = null): Response
    {
        return $this->statusCode(404, $content);
    }

    protected function unprocessableEntity($content = null): Response
    {
        return $this->statusCode(422, $content);
    }

    protected function internalError(): Response
    {
        return $this->statusCode(500);
    }
}
