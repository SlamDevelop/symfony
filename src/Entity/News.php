<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class News
 * @package App\Entity
 * @ORM\Entity
 */
class News
{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=150)
	 */
	public $s_title;
	
	/**
	  * @ORM\Column(type="string", length=255)
	 */
	public $s_desc;
	
	/**
	  * @ORM\Column(type="string", length=50)
	 */
	public $s_category;
	
	/**
	  * @ORM\Column(type="string", length=255, nullable=true)
	  *
      * @Assert\File(mimeTypes={"image/png", "image/gif", "image/jpg", "image/jpeg"})
	 */
	public $s_image;
	
	
	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}
	
	
	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->s_title;
	}
	
	/**
	 * @param mixed $s_title
	 */
	public function setTitle($s_title): void
	{
		$this->s_title = $s_title;
	}
	
	/**
	 * @return mixed
	 */
	public function getDesc()
	{
		return $this->s_desc;
	}
	
	/**
	 * @param mixed $s_desc
	 */
	public function setDesc($s_desc): void
	{
		$this->s_desc = $s_desc;
	}
	
	/**
	 * @return mixed
	 */
	public function getCategory()
	{
		return $this->s_category;
	}
	
	/**
	 * @param mixed $s_category
	 */
	public function setCategory($s_category): void
	{
		$this->s_category = $s_category;
	}
	
	/**
	 * @return mixed
	 */
	public function getImage()
	{
		return $this->s_image;
	}
	
	/**
	 * @param mixed $s_image
	 */
	public function setImage($s_image): void
	{
		$this->s_image = $s_image;
	}
}