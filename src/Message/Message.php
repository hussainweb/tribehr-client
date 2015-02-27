<?php

namespace Hussainweb\TribeHr\Message;

/**
 * Message class for basic usage across all message entities.
 */
class Message
{
    /**
     * @var array
     */
    private $rawData;

    public function __construct($data = NULL)
    {
        if (isset($data))
        {
            $this->setData($data);
        }
    }

    /**
     * Get the raw data for the message.
     *
     * @return array
     */
    protected function getRawData()
    {
        return $this->rawData;
    }

    /**
     * Set raw data for the message.
     *
     * @param array $raw_data
     * Raw data for a request or response.
     */
    protected function setRawData(array $raw_data)
    {
        $this->rawData = $raw_data;
    }

    public function getData()
    {
        return $this->getRawData();
    }

    public function setData(array $data)
    {
        $this->setRawData($data);
    }

    public function getPostData()
    {
        return http_build_query($this->getData());
    }
}
