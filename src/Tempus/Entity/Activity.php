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
 * Tempus\Entity\Activity
 *
 * @ORM\Table(name="activity")
 * @ORM\Entity
 */
class Activity
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
	 * @var string
	 *
	 * @ORM\Column(name="description", type="string", length=1024)
	 */
	private $description;

	/**
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false)
     */
    protected $project;

	/**
	 * Constructor
	 *
	 * @param string $name
	 */
	public function __construct(Project $project, $name)
	{
		$this->project = $project;
		$this->name = $name;
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
	 * Description
	 *
	 * @return string
	 */
	public function description()
	{
		return $this->description;
	}

	/**
	 * Project
	 *
	 * @return Project
	 */
	public function project()
	{
		return $this->project;
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

	/**
	 * Set description
	 *
	 * @param string $string
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}
}
