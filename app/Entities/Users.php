<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Facades\Hash;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $password_hash;

    /**
     * @ORM\Column(type="text")
     */
    protected $info;

    /**
     * Users constructor.
     * @param $name
     * @param $password
     * @param $info
     */
    public function __construct($name, $password, $info)
    {
        $this->name = $name;
        $this->password_hash = Hash::make($password);
        $this->info = $info;
    }

    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getPasswordHash()
    {
        return $this->password_hash;
    }
}