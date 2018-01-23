<?php

namespace Aurora\Http\Handler;

interface HandlerInterface
{
    /**
     * @param mixed            $request
     * @param HandlerInterface $next
     * @return mixed
     */
    public function handle($request, HandlerInterface $next);
}