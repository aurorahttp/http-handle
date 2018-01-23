<?php

namespace Aurora\Http\Handler;

use Closure;

interface ReplaceableInterface
{
    /**
     * @param Closure $handle
     */
    public function replace($handle);
}