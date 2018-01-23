<?php

namespace Aurora\Http\Handler\Tests;

class PriorityHandler implements \Aurora\Http\Handler\PriorityHandlerInterface
{
    public $number;

    public function __construct($number = 0)
    {
        $this->number = $number;
    }

    public function handle($request, \Aurora\Http\Handler\HandlerInterface $next)
    {
        return $next->handle($request . $this->number, $next);
    }

    public function getPriority()
    {
        return $this->number;
    }
}