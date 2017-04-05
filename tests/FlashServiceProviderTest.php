<?php

namespace Jalle19\Laravel\UnshittyFlash\Tests;

use Illuminate\Contracts\Foundation\Application;
use Jalle19\Laravel\UnshittyFlash\FlashService;
use Jalle19\Laravel\UnshittyFlash\FlashServiceProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class FlashServiceProviderTest
 * @package Jalle19\Laravel\UnshittyFlash\Tests
 */
class FlashServiceProviderTest extends TestCase
{

    /**
     * Tests that the service provider actually tries to register the service
     */
    public function testRegister()
    {
        /* @var Application|\PHPUnit_Framework_MockObject_MockObject $app */
        $app = $this->getMockBuilder(Application::class)
                    ->setMethods(['singleton'])
                    ->getMockForAbstractClass();

        // Check that we're actually trying to register the service
        $app->expects($this->once())
            ->method('singleton')
            ->with($this->equalTo(FlashService::class));

        $serviceProvider = new FlashServiceProvider($app);
        $serviceProvider->register();
    }

}
