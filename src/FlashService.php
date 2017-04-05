<?php

namespace Jalle19\Laravel\UnshittyFlash;

use Illuminate\Http\Request;

/**
 * Class FlashService
 * @package Jalle19\Laravel\UnshittyFlash
 */
class FlashService
{

    const LEVEL_SUCCESS = 'success';
    const LEVEL_INFO    = 'info';
    const LEVEL_WARNING = 'warning';
    const LEVEL_DANGER  = 'danger';

    /**
     * @var string
     */
    private $sessionKey;


    /**
     * FlashService constructor.
     *
     * @param array $configuration
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $configuration)
    {
        if (!isset($configuration['session_key'])) {
            throw new \InvalidArgumentException('session_key cannot be empty');
        }

        $this->sessionKey = $configuration['session_key'];
    }


    /**
     * @param Request $request
     * @param string  $message
     * @param string  $level
     * @param bool    $sameRequest
     */
    public function message(Request $request, string $message, string $level, bool $sameRequest = false)
    {
        $session = $request->session();

        $data = $session->get($this->sessionKey, []);

        // Append the new message and store again
        $data[] = ['message' => $message, 'level' => $level];

        // Flash the message, either immediately or for the next request
        if ($sameRequest) {
            $session->now($this->sessionKey, $data);
        } else {
            $session->flash($this->sessionKey, $data);
        }
    }


    /**
     * @param Request $request
     * @param string  $message
     * @param bool    $sameRequest
     */
    public function success(Request $request, string $message, bool $sameRequest = false)
    {
        $this->message($request, $message, self::LEVEL_SUCCESS, $sameRequest);
    }


    /**
     * @param Request $request
     * @param string  $message
     * @param bool    $sameRequest
     */
    public function info(Request $request, string $message, bool $sameRequest = false)
    {
        $this->message($request, $message, self::LEVEL_INFO, $sameRequest);
    }


    /**
     * @param Request $request
     * @param string  $message
     * @param bool    $sameRequest
     */
    public function warning(Request $request, string $message, bool $sameRequest = false)
    {
        $this->message($request, $message, self::LEVEL_WARNING, $sameRequest);
    }


    /**
     * @param Request $request
     * @param string  $message
     * @param bool    $sameRequest
     */
    public function danger(Request $request, string $message, bool $sameRequest = false)
    {
        $this->message($request, $message, self::LEVEL_DANGER, $sameRequest);
    }

}
