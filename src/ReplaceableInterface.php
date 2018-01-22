<?php

namespace Aurora\Http\Handle;

use Closure;

interface ReplaceableInterface
{
    /**
     * @param Closure $handle
     */
    public function replace($handle);
}