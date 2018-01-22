<?php

use Aurora\Http\Handle\ClosureHandler;
use PHPUnit\Framework\TestCase;

class ClosureHandlerTest extends TestCase
{
    public function testHandle()
    {
        $handler = new ClosureHandler(function($request) {
           return 'A and ' . $request;
        });

        $this->assertEquals('A and B', $handler->handle('B'));
    }
}
