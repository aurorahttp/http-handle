<?php

namespace Aurora\Http\Handler;

interface PriorityHandlerInterface extends HandlerInterface
{
    /**
     * @return int
     */
    public function getPriority();
}