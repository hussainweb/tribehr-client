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

    public function setData($data)
    {
        parent::setData($data);

        $this->values = $data['values'];
        $this->comments = $data['comments'];
    }

    public function getPostData()
    {
        $data = [
            'text' => $this->getText(),
        ];

        array_walk($this->getRecipients(), function ($value) use (&$data) {
            /** @var $value \Hussainweb\TribeHr\Message\UserBasic */
            $data['recipients[][id]'] = $value->getId();
        });

        array_walk($this->getValues(), function ($value) use (&$data) {
            $data['values[][id]'] = $value['id'];
        });

        return http_build_query($data);
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
