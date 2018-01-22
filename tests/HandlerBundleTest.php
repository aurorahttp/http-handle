<?php

use Aurora\Http\Handle\HandlerBundle;
use PHPUnit\Framework\TestCase;

class Handler implements \Aurora\Http\Handle\HandlerInterface
{
    public $number;

    public function __construct($number = null)
    {
        $this->number = $number;
    }

    public function handle($request)
    {
        return $request + 1;
    }

}

class HandlerBundleTest extends TestCase
{

    public function testReadAndWrite()
    {
        $bundle = new HandlerBundle();
        $this->assertCount(0, $bundle);
        list($o, $p, $q) = $this->insertBundle($bundle, 3);


        $this->assertCount(3, $bundle);
        $this->assertSame($o, $bundle->front());
        $this->assertSame($q, $bundle->back());

        $bundle->pop();
        $this->assertSame($p, $bundle->back());

        $bundle->clear();
        $this->assertTrue($bundle->isEmpty());
    }


    public function testSerialize()
    {
        $bundle = new HandlerBundle();
        $this->insertBundle($bundle, 3);
        $serialize = $bundle->serialize();
        $bundle->clear();
        $this->assertCount(0, $bundle);
        $bundle->unserialize($serialize);
        $this->assertCount(3, $bundle);
    }

    public function testIterator()
    {
        $bundle = new HandlerBundle();
        $list = $this->insertBundle($bundle, 3);
        foreach ($bundle as $key => $handler) {
            $this->assertSame($list[$key], $handler);
        }
    }

    public function testArrayAccess()
    {
        $bundle = new HandlerBundle();
        $bundle[] = $handler = new Handler();
        $this->assertSame($handler, $bundle[0]);
        $this->assertTrue(isset($bundle[0]));
        unset($bundle[0]);
        $this->assertFalse(isset($bundle[0]));
    }

    public function testHandle()
    {
        $bundle = new HandlerBundle();
        $this->insertBundle($bundle, 3);
        $this->assertEquals(4, $bundle->handle(1));
    }

    protected function insertBundle(HandlerBundle $bundle, $count)
    {
        $list = [];
        for ($i = 0; $i < $count; ++$i) {
            $list[$i] = new Handler($i);
            $bundle->insert($i, $list[$i]);
        }

        return $list;
    }
}
