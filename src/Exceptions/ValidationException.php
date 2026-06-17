<?php

namespace Vendor\Cloudflare\Exceptions;

class ValidationException extends ApiException
{
    public function getErrors(): array
    {
        return $this->details;
    }
}
