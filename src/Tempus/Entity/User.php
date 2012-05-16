<?php

/*
 * This file is a part of tempus/tempus-webapp.
 * 
 * (c) Josh LaRosee
 *     Beau Simensen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tempus\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tempus\Entity\User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="username", type="string", length=255)
	 */
	private $username;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="password", type="string", length=128)
	 */
	private $password;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="updated_at", type="datetime")
	 */
	private $updated_at;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="created_at", type="datetime")
	 */
	private $created_at;


	/**
	 * Constructor
	 *
	 * @param string $name
	 */
	public function __construct($username)
	{
		$this->username = $username;
	}

	/**
	 * Username
	 *
	 * @return string
	 */
	public function username()
	{
		return $this->username;
	}

	/**
	 * Set username
	 *
	 * @param string $name
	 */
	public function setUserame($username)
	{
		$this->username = $username;
	}

	/**
	 * Password
	 *
	 * @return string
	 */
	public function password()
	{
		return $this->password;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

}
