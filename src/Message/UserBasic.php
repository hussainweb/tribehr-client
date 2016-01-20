<?php

namespace Hussainweb\TribeHr\Message;

class UserBasic extends MessageWithId
{

    private $username;
    private $email;
    private $displayName;
    private $employeeRecord;
    private $url;

    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    public function getData()
    {
        $data = parent::getData();

        $data['username'] = $this->username;
        $data['email'] = $this->email;
        $data['display_name'] = $this->displayName;
        $data['employee_record'] = $this->employeeRecord;
        $data['url'] = $this->url;

        return $data;
    }

    public function setData(array $data)
    {
        parent::setData($data);

        $data += [
          'id' => '',
          'username' => '',
          'email' => '',
          'display_name' => '',
          'employee_record' => [],
          'url' => '',
        ];

        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->displayName = $data['display_name'];
        $this->employeeRecord = $data['employee_record'];
        $this->url = $data['url'];
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param mixed $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return mixed
     */
    public function getEmployeeRecord()
    {
        return $this->employeeRecord;
    }

    /**
     * @param mixed $employeeRecord
     */
    public function setEmployeeRecord($employeeRecord)
    {
        $this->employeeRecord = $employeeRecord;
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
}
