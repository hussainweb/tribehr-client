<?php

namespace Hussainweb\TribeHr\Message;

class Kudos extends KudosBasic
{
    private $values;
    private $comments;

    public function __construct($data = NULL)
    {
        parent::__construct($data);
    }

    public function setData(array $data)
    {
        parent::setData($data);

        $this->values = $data['values'];
        $this->comments = $data['comments'];
    }

    public function getPostData()
    {
        $data = [
            'text=' . urlencode($this->getText()),
        ];

        $recipients = $this->getRecipients();
        array_walk($recipients, function ($value) use (&$data) {
            /** @var $value \Hussainweb\TribeHr\Message\UserBasic */
            $data[] = urlencode('recipients[][id]') . '=' . urlencode($value->getId());
        });

        $values = $this->getValues() ?: [];
        array_walk($values, function ($value) use (&$data) {
            $data[] = urlencode('values[][id]') . '=' . urlencode($value['id']);
        });

        return implode('&', $data);
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param mixed $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

}
