<?php

namespace Jalle19\Laravel\UnshittyFlash\Tests;

use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Arr;
use Jalle19\Laravel\UnshittyFlash\FlashService;
use PHPUnit\Framework\TestCase;
use SessionHandlerInterface;

/**
 * Class FlashServiceTest
 * @package Jalle19\Laravel\UnshittyFlash\Tests
 */
class FlashServiceTest extends TestCase
{

    const SESSION_KEY = 'flash_notifications';


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMissingConfiguration()
    {
        new FlashService([]);
    }


    /**
     *
     */
    public function testWorkingConfiguration()
    {
        $this->assertInstanceOf(FlashService::class, $this->getFlashService());
    }


    /**
     *
     */
    public function testMessage()
    {
        $request = new Request();
        $request->setLaravelSession(new Store('test', new ArraySessionHandler()));

        // Add a single message
        $this->getFlashService()->success($request, 'Test message');
        $this->assertCount(1, $request->session()->get(self::SESSION_KEY));

        // Add the exact same message again, but flash to the current request
        $this->getFlashService()->success($request, 'Test message', true);
        $this->assertCount(2, $request->session()->get(self::SESSION_KEY));

        // Add another one of the same level, should be two now
        $this->getFlashService()->success($request, 'Test message #2');
        $this->assertCount(3, $request->session()->get(self::SESSION_KEY));

        // Add the same message but with the other levels
        $this->getFlashService()->info($request, 'Test message');
        $this->getFlashService()->warning($request, 'Test message');
        $this->getFlashService()->danger($request, 'Test message');
        $this->assertCount(6, $request->session()->get(self::SESSION_KEY));

        // Check the full session contents
        $this->assertEquals([
            [
                'message' => 'Test message',
                'level'   => FlashService::LEVEL_SUCCESS,
            ],
            [
                'message' => 'Test message',
                'level'   => FlashService::LEVEL_SUCCESS,
            ],
            [
                'message' => 'Test message #2',
                'level'   => FlashService::LEVEL_SUCCESS,
            ],
            [
                'message' => 'Test message',
                'level'   => FlashService::LEVEL_INFO,
            ],
            [
                'message' => 'Test message',
                'level'   => FlashService::LEVEL_WARNING,
            ],
            [
                'message' => 'Test message',
                'level'   => FlashService::LEVEL_DANGER,
            ],
        ], $request->session()->get(self::SESSION_KEY));
    }


    /**
     * @return FlashService
     */
    private function getFlashService()
    {
        return new FlashService([
            'session_key' => self::SESSION_KEY,
        ]);
    }

}

/**
 * Class ArraySessionHandler
 * @package Jalle19\Laravel\UnshittyFlash\Tests
 */
class ArraySessionHandler implements SessionHandlerInterface
{

    /**
     * @var array
     */
    private $data = [];


    /**
     * @inheritdoc
     */
    public function close()
    {

    }


    /**
     * @inheritdoc
     */

    public function destroy($session_id)
    {

    }


    /**
     * @inheritdoc
     */
    public function gc($maxlifetime)
    {

    }


    /**
     * @inheritdoc
     */
    public function open($save_path, $name)
    {

    }


    /**
     * @inheritdoc
     */
    public function read($session_id)
    {
        Arr::get($this->data, $session_id);
    }


    /**
     * @inheritdoc
     */
    public function write($session_id, $session_data)
    {
        Arr::set($this->data, $session_id, $session_data);
    }

}
