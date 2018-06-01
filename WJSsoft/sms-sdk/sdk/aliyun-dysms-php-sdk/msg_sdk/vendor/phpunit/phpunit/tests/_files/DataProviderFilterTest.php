<?php
class DataProviderFilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider truthProvider
     */
    public function testTrue($truth)
    {
        $this->assertTrue($truth);
    }

    public static function truthProvider()
    {
        return array(
           array(true),
           array(true),
           array(true),
           array(true)
        );
    }

    /**
     * @dataProvider falseProvider
     */
    public function testFalse($false)
    {
        $this->assertFalse($false);
    }

    public static function falseProvider()
    {
        return array(
          'false demo'       => array(false),
          'false demo 2'     => array(false),
          'other false demo' => array(false),
          'other false test2'=> array(false)
        );
    }
}
