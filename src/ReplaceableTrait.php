<?php

namespace Aurora\Http\Handle;

use Closure;

trait ReplaceableTrait
{
    /**
     * @var callable
     */
    protected $handle;

    /**
     * Replace class handle method.
     *
     * @param callable $handle
     * @param bool     $bindTo
     */
    public function replace($handle, $bindTo = true)
    {
        if ($bindTo && $handle instanceof Closure) {
            $handle = $handle->bindTo($this, $this);
        }
        $this->handle = $handle;
    }

    public function handle()
    {
        if ($this->handle !== null) {
            call_user_func($this->handle);
        }
    }
}