<?php

namespace Hussainweb\TribeHr\Message;

use Hussainweb\TribeHr\TribeHrException;

class KudosBasic extends MessageWithId
{

    private $poster;
    private $recipients;
    private $picture;
    private $text;
    private $commentCount;
    private $url;
    private $source;
    private $created;

    public function setData(array $data)
    {
        parent::setData($data);

        if (!isset($data['poster'])
            || !isset($data['recipients'])
            || !isset($data['text'])
        ) {
            throw new TribeHrException(["Missing required data"]);
        }

        $this->poster = new UserBasic($data['poster']);
        $this->setRecipients($data['recipients']);
        $this->picture = isset($data['picture']) ? $data['picture'] : null;
        $this->text = $data['text'];
        $this->commentCount = isset($data['comment_count']) ? $data['comment_count'] : null;
        $this->url = isset($data['url']) ? $data['url'] : null;
        $this->source = isset($data['source']) ? $data['source'] : '';
        $this->created = isset($data['created']) ? $data['created'] : null;
    }

    /**
     * @return \Hussainweb\TribeHr\Message\UserBasic
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * @param \Hussainweb\TribeHr\Message\UserBasic $poster
     */
    public function setPoster(UserBasic $poster)
    {
        $this->poster = $poster;
    }

    /**
     * @return \Hussainweb\TribeHr\Message\UserBasic[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param array $recipients
     */
    public function setRecipients(array $recipients)
    {
        $this->recipients = array_map(function ($data) {
            return $data instanceof UserBasic ? $data : new UserBasic($data);
        }, $recipients);
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * @param mixed $commentCount
     */
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }
}
