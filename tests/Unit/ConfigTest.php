<?php
namespace SmoDav\AfricasTalking\Tests\Unit;

use SmoDav\AfricasTalking\Native\NativeConfig;
use SmoDav\AfricasTalking\Tests\TestCase;

class ConfigTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test that configuration store receives a call.
     *
     * @test
     **/
    public function verifyGet()
    {
        $configStore = new NativeConfig();
        $this->assertEquals('sandbox', $configStore->get('africastalking.username'));
        $this->assertEquals('', $configStore->get('africastalking.api_key'));
        $this->assertEquals(true, $configStore->get('africastalking.sandbox'));
        $this->assertEquals(false, $configStore->get('africastalking.debug'));
    }
}
