<?php

namespace Aurora\Http\Handle;

use ArrayAccess;
use Countable;
use InvalidArgumentException;
use Iterator;
use Serializable;
use SplDoublyLinkedList;

/**
 * Class HandlerList
 *
 * @author Panlatent <panlatent@gmail.com>
 */
class HandlerBundle implements Iterator, Countable, ArrayAccess, Serializable, HandlerInterface
{
    /**
     * @var HandlerInterface[]|SplDoublyLinkedList
     */
    protected $store;

    /**
     * HandlerList constructor.
     */
    public function __construct()
    {
        $this->store = new SplDoublyLinkedList();
    }

    /**
     * Process a request using all stored handlers.
     *
     * @param mixed $request
     * @return mixed
     */
    public function handle($request)
    {
        foreach ($this->store as $handler) {
            $result = $handler->handle($request);
            if ($request === false) {
                break;
            } elseif ($request !== null) {
                $request = $result;
            }
        }

        return $request;
    }

    /**
     * @param mixed            $index
     * @param HandlerInterface $handler
     */
    public function insert($index, HandlerInterface $handler)
    {
        $this->store->add($index, $handler);
    }

    /**
     * @return HandlerInterface
     */
    public function pop()
    {
        return $this->store->pop();
    }

    /**
     * @return HandlerInterface
     */
    public function popFront()
    {
        return $this->store->shift();
    }

    /**
     * @param HandlerInterface $value
     */
    public function push(HandlerInterface $value)
    {
        $this->store->push($value);
    }

    /**
     * @param HandlerInterface $value
     */
    public function pushFront(HandlerInterface $value)
    {
        $this->store->unshift($value);
    }

    /**
     * @return HandlerInterface
     */
    public function front()
    {
        return $this->store->top();
    }

    /**
     * @return HandlerInterface
     */
    public function back()
    {
        return $this->store->bottom();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->store->count();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->store->isEmpty();
    }

    /**
     * Clear all handlers.
     */
    public function clear()
    {
        for (; ! $this->store->isEmpty(); ) {
            $this->store->pop();
        }
    }

    /**
     * @param int $size
     */
    public function resize($size)
    {
        for ($i = $this->store->count(); $i > $size; --$i) {
            $this->store->pop();
        }
    }

    /**
     * @param HandlerBundle $handlerList
     */
    public function merge(HandlerBundle $handlerList)
    {
        foreach ($handlerList as $handler) {
            $this->store->push($handler);
        }
    }

    /**
     * @param mixed $index
     * @return bool
     */
    public function offsetExists($index)
    {
        return $this->store->offsetExists($index);
    }

    /**
     * @param mixed $index
     * @return HandlerInterface
     */
    public function offsetGet($index)
    {
        return $this->store->offsetGet($index);
    }

    /**
     * @param mixed            $index
     * @param HandlerInterface $handler
     */
    public function offsetSet($index, $handler)
    {
        if (! $handler instanceof HandlerInterface) {
            throw new InvalidArgumentException('The second parameter must implement the ' .
                HandlerInterface::class . ' interface');
        }

        $this->store->offsetSet($index, $handler);
    }

    /**
     * @param mixed $index
     */
    public function offsetUnset($index)
    {
        $this->store->offsetUnset($index);
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
     * @return mixed
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
     * Move to previous entry
     */
    public function prev()
    {
        $this->store->prev();
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
}