<?php

namespace Hussainweb\TribeHr\Message;

class Kudos extends KudosBasic
{
    private $values;
    private $comments;

    public function setData(array $data)
    {
        parent::setData($data);

        $this->values = isset($data['values']) ? $data['values'] : [];
        $this->comments = isset($data['comments']) ? $data['comments'] : [];
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
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues(array $values)
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
