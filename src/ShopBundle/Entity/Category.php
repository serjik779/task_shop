<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\categoryRepository")
 */
class category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var image
     *
     * @ORM\ManyToMany(targetEntity="ShopBundle\Entity\image")
     * @ORM\JoinColumn(name="image", referencedColumnName="id")
     */
    private $image;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    }
