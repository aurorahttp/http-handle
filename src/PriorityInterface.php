<?php

namespace Aurora\Http\Handler;

interface PriorityInterface
{
    /**
     * @return int
     */
    public function getPriority();
}