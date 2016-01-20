<?php

namespace Hussainweb\TribeHr\Message;

use Hussainweb\TribeHr\TribeHrException;

class LeaveBasic extends MessageWithId
{

    /**
     * @var \DateTimeInterface
     */
    private $startDate;

    /**
     * @var \DateTimeInterface
     */
    private $endDate;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $url;

    /**
     * @var \Hussainweb\TribeHr\Message\UserBasic
     */
    private $user;

    /**
     * @var array
     */
    private $leaveType;

    public function setData(array $data)
    {
        parent::setData($data);

        $data += [
            'id' => '',
            'leave_type' => [],
            'status' => '',
        ];

        if (!isset($data['date_start'])
            || !isset($data['date_end'])
            || !isset($data['url'])
            || !isset($data['user'])
        ) {
            throw new TribeHrException(["Missing required data"]);
        }

        $this->startDate = $data['date_start'] instanceof \DateTimeInterface
            ? $data['date_start']
            : new \DateTime($data['date_start']);
        $this->endDate = $data['date_end'] instanceof \DateTimeInterface
            ? $data['date_end']
            : new \DateTime($data['date_end']);
        $this->status = $data['status'];
        $this->url = $data['url'];
        $this->user = new UserBasic($data['user']);
        $this->leaveType = $data['leave_type'];
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     */
    public function setDuration(\DateTimeInterface $startDate, \DateTimeInterface $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return UserBasic
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserBasic $user
     */
    public function setUser(UserBasic $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getLeaveType()
    {
        return $this->leaveType;
    }

    /**
     * @param array $leaveType
     */
    public function setLeaveType(array $leaveType)
    {
        $this->leaveType = $leaveType;
    }
}
