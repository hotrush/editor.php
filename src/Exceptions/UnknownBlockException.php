<?php

declare(strict_types=1);

namespace Hotrush\EditorPhp\Exceptions;

use Exception;

class UnknownBlockException extends Exception
{
    public function __construct(string $block)
    {
        parent::__construct("Unknown block: {$block}");
    }
}
