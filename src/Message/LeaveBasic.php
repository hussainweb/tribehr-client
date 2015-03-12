<?php

namespace Hussainweb\TribeHr\Message;

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
            'status' => '',
        ];

        $this->startDate = $data['date_start'];
        $this->endDate = $data['date_end'];
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
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
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
    public function setUser($user)
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
    public function setLeaveType($leaveType)
    {
        $this->leaveType = $leaveType;
    }
}
