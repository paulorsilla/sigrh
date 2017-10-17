<?php
/**
 * @link      http://github.com/zendframework/zend-mvc-plugin-identity for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Mvc\Plugin\Identity\TestAsset;

class IdentityObject
{
    /**
     * @var string|null
     */
    protected $username;

    /**
     * @var string|null
     */
    protected $password;

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = (string) $username;
    }

    /**
     * @return string|null
     */
    public function getUsername()
    {
        return $this->username;
    }
}
