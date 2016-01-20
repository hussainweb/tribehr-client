<?php
/**
 * Exception object for TribeHR.
 */

namespace Hussainweb\TribeHr;

class TribeHrException extends \Exception
{
    protected $messages;

    public function __construct(
        $messages = [],
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct(implode("\n", $messages), $code, $previous);
        $this->messages = $messages;
    }

    /**
     * Messages returned by TribeHR API.
     *
     * @return string[]
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
