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
 * Tempus\Entity\Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class Project
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
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
     */
    protected $activities = array();

	/**
	 * Constructor
	 *
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->name = $name;
      	$this->activities = new ArrayCollection();

	}

	public function setActivity($activity)
    {
        $activity->assignedToProject($this);
        $this->activities[] = $activity;
    }

	/**
	 * [getActivities description]
	 * @return [type]
	 */
	public function getActivities()
	{
		return $this->activity;
	}

	/**
	 * Id
	 *
	 * @return id
	 */
	public function id()
	{
		return $this->id;
	}

	/**
	 * Name
	 *
	 * @return string
	 */
	public function name()
	{
		return $this->name;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
}
