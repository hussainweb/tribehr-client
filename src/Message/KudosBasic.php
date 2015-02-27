<?php

namespace Hussainweb\TribeHr\Message;

class KudosBasic extends Message
{

    private $id;
    private $poster;
    private $recipients;
    private $picture;
    private $text;
    private $commentCount;
    private $url;
    private $source;
    private $created;

    public function setData($data)
    {
        parent::setData($data);

        $this->id = $data['id'];
        $this->poster = new UserBasic($data['poster']);
        $this->recipients = array_map(function ($data) {
            return new UserBasic($data);
        }, $data['recipients']);
        $this->picture = $data['picture'];
        $this->text = $data['text'];
        $this->commentCount = $data['comment_count'];
        $this->url = $data['url'];
        $this->source = $data['source'];
        $this->created = $data['created'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function setPoster($poster)
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
     * @param \Hussainweb\TribeHr\Message\UserBasic[] $recipients
     */
    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;
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
