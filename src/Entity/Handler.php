<?php

namespace App\Entity;

/**
 * Class Handler
 * @package App\Entity
 */
class Handler
{
	/**
	 * @return string
	 */
	public function generateUniqueFileName()
	{
		return md5(uniqid());
	}
	
	/**
	 * @return string
	 */
	public function saveImage($file, $path)
	{
		$fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

		$file->move($path, $fileName);
		return $fileName;
	}
}