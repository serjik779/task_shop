<?php

namespace ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="products", indexes={@ORM\Index(name="fk_category", columns={"category_id"})})
 * @ORM\Entity
 */
class Products
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float", precision=10, scale=0, nullable=false)
     */
    private $cost;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var integer
     *
     * @ORM\Column(name="service_id", type="integer", nullable=false)
     */
    private $serviceId;

    /**
     * @var Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var ArrayCollection|Images[]
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="ShopBundle\Entity\Images", mappedBy="products")
     */
    protected $images;

    /**
     * Products constructor.
     */
    public function __construct()
    {
        $this->images[] = new ArrayCollection();
    }

    public function addImage(Images $image) {
        $this->images[] = $image;
    }



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Products
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
     * Set description
     *
     * @param string $description
     * @return Products
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Products
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set cost
     *
     * @param float $cost
     * @return Products
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return float 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return Products
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set serviceId
     *
     * @param integer $serviceId
     * @return Products
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;

        return $this;
    }

    /**
     * Get serviceId
     *
     * @return integer 
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * Set category
     *
     * @param \ShopBundle\Entity\Categories $category
     * @return Products
     */
    public function setCategory(\ShopBundle\Entity\Categories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ShopBundle\Entity\Categories 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Remove images
     *
     * @param \ShopBundle\Entity\Images $images
     */
    public function removeImage(\ShopBundle\Entity\Images $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}
