<?php

namespace Hussainweb\TribeHr\Message;

class MessageWithId extends Message
{

    /**
     * @var string The identifier for this message.
     */
    private $id;

    public function __construct($data = NULL)
    {
        parent::__construct($data);
        $this->id = $data['id'] ?: NULL;
    }

    /**
     * Get the Id for this message.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the Id for this message.
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getData() {
        $data = parent::getData();
        $data['id'] = $this->getId();
        return $data;
    }

    public function setData(array $data)
    {
        parent::setData($data);

        $this->id = $data['id'];
    }
}
