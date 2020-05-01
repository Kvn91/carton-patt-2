<?php

namespace App\Document;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups as Groups;

/**
 * Class Restaurant
 *
 * @author Kev
 *
 * @MongoDB\Document(repositoryClass="App\Repository\RestaurantRepository", collection="restaurants")
 * @ApiResource
 */
class Restaurant
{
	/**
	 * @var string
	 * @MongoDB\Id
	 * @Groups("restaurant:read")
	 */
	protected $id;

	/**
	 * @var string
	 *
	 * @MongoDB\Field(type="string")
	 * @Groups("restaurant:read")
	 * @Assert\NotBlank
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @MongoDB\Field(type="string")
	 * @Groups("restaurant:read")
	 * @Assert\NotBlank(message="La description est obligatoire")
	 */
	protected $description;

	/**
	 * @var string
	 *
	 * @MongoDB\Field(type="string")
	 * @Groups("restaurant:read")
	 * @Assert\NotBlank
	 */
	protected $type;

	/**
	 * @var \DateTime
	 *
	 * @Gedmo\Timestampable(on="create")
	 * @MongoDB\Field(type="date")
	 */
	protected $createdAt;

	/**
	 * @var \DateTime
	 *
	 * @Gedmo\Timestampable(on="update")
	 * @MongoDB\Field(type="date")
	 */
	protected $updatedAt;

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 * @return Restaurant
	 */
	public function setId($id): Restaurant
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Restaurant
	 */
	public function setName(string $name): Restaurant
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return Restaurant
	 */
	public function setDescription(string $description): Restaurant
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return Restaurant
	 */
	public function setType(string $type): Restaurant
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}

	/**
	 * @param \DateTime $createdAt
	 * @return Restaurant
	 */
	public function setCreatedAt(\DateTime $createdAt): Restaurant
	{
		$this->createdAt = $createdAt;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt(): \DateTime
	{
		return $this->updatedAt;
	}

	/**
	 * @param \DateTime $updatedAt
	 * @return Restaurant
	 */
	public function setUpdatedAt(\DateTime $updatedAt): Restaurant
	{
		$this->updatedAt = $updatedAt;
		return $this;
	}
}
