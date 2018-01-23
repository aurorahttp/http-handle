<?php

namespace Aurora\Http\Handler\Bundle;

use Aurora\Http\Handler\Bundle;
use Aurora\Http\Handler\HandlerInterface;
use Aurora\Http\Handler\PriorityHandlerInterface;
use SplPriorityQueue;

class PriorityBundle extends Bundle
{
    /**
     * @var PriorityHandlerInterface[]|SplPriorityQueue
     */
    protected $store;
    /**
     * @var bool
     */
    protected $shadow = false;

    public function __construct()
    {
        $this->store = new SplPriorityQueue();
    }

    /**
     * @param mixed            $request
     * @param HandlerInterface $next
     * @return PriorityHandlerInterface|mixed
     */
    public function handle($request, HandlerInterface $next)
    {
        if ($this->isEmpty()) {
            return $request;
        }
        if ($this->shadow == false) {
            $bundle = clone $this;
            $bundle->shadow = true;
            if ($next instanceof PriorityHandlerInterface) {
                $bundle->insert($next);;
                return $bundle->extract()->handle($request, $bundle);
            }

            return $next->handle($request, $bundle);
        }
        $handler = $this->extract();

        return $handler->handle($request, $this);
    }

    /**
     * @return PriorityHandlerInterface
     */
    public function extract()
    {
        return $this->store->extract();
    }

    /**
     * @param PriorityHandlerInterface $value
     */
    public function insert(PriorityHandlerInterface $value)
    {
        $this->store->insert($value, $value->getPriority());
    }

    /**
     * @return PriorityHandlerInterface
     */
    public function top()
    {
        return $this->store->top();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->store->isEmpty();
    }
}