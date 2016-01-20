<?php
/**
 * Exception object for TribeHR.
 */

namespace Hussainweb\TribeHr;

class TribeHrException extends \Exception
{
    protected $messages;

    protected $codes = [
        'INVALID_ID' => 404,
        'NOT_FOUND' => 404,
        'ID_MISMATCH' => 400,
        'DELETE_ERROR' => 500,
        'SAVE_ERROR' => 500,
        'VALIDATION_ERROR' => 400,
        'RIGHTS_ERROR' => 403,
        'ACCESS_ERROR' => 403,
        'CONNECTION_ERROR' => 500,
        'UNKNOWN_SUBDOMAIN' => 404,
        'MAINTENANCE' => 503,
        'ERROR' => 500,
    ];

    public function __construct(
        $messages = [],
        $code = 0,
        \Exception $previous = null
    ) {
        if (!is_numeric($code)) {
            $code = isset($this->codes[$code]) ? $this->codes[$code] : 0;
        }

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
