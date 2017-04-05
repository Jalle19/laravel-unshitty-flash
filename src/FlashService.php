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
     */
    public function message(Request $request, string $message, string $level)
    {
        $session = $request->session();

        // Retrieve any existing data
        $data = $session->get($this->sessionKey, []);

        // Append the new message and store again
        $data[] = ['message' => $message, 'level' => $level];
        $session->flash($this->sessionKey, $data);
    }


    /**
     * @param Request $request
     * @param string  $message
     */
    public function success(Request $request, string $message)
    {
        $this->message($request, $message, self::LEVEL_SUCCESS);
    }


    /**
     * @param Request $request
     * @param string  $message
     */
    public function info(Request $request, string $message)
    {
        $this->message($request, $message, self::LEVEL_INFO);
    }


    /**
     * @param Request $request
     * @param string  $message
     */
    public function warning(Request $request, string $message)
    {
        $this->message($request, $message, self::LEVEL_WARNING);
    }


    /**
     * @param Request $request
     * @param string  $message
     */
    public function danger(Request $request, string $message)
    {
        $this->message($request, $message, self::LEVEL_DANGER);
    }

}
