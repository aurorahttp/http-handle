<?php

namespace Aurora\Http\Handler;

use Countable;
use Iterator;

abstract class Bundle implements BundleInterface
{
    /**
     * @var HandlerInterface[]|Iterator|Countable
     */
    protected $store;

    /**
     * @return int
     */
    public function count()
    {
        return $this->store->count();
    }

    /**
     * Rewind store
     */
    public function rewind()
    {
        $this->store->rewind();
    }

    /**
     * @return HandlerInterface
     */
    public function current()
    {
        return $this->store->current();
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->store->key();
    }

    /**
     * Move forward to next element
     */
    public function next()
    {
        $this->store->next();
    }
    /**
     * @return bool
     */
    public function valid()
    {
        return $this->store->valid();
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->store);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->store = unserialize($serialized);
    }

    /**
     * Copy a new store.
     */
    public function __clone()
    {
        $this->store = clone $this->store;
    }
}