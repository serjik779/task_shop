<?php
namespace ShopBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Categories
 *
 * @ORM\Table(name="categories", indexes={@ORM\Index(name="fk_image", columns={"image_id"})})
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\CategoriesRepository")
 */
class Categories
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
     * @var Images
     *
     * @ORM\ManyToOne(targetEntity="Images", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * })
     */
    private $image;
    /**
     * @var ArrayCollection|Products[]
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\Products", mappedBy="category")
     */
    protected $products;
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=128, nullable=false, unique=true )
     */
    private $slug;
    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * @param int $id
     * @return Categories
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Set title
     *
     * @param string $title
     * @return Categories
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
     * Set image
     *
     * @param \ShopBundle\Entity\Images $image
     * @return Categories
     */
    public function setImage(\ShopBundle\Entity\Images $image = null)
    {
        $this->image = $image;
        return $this;
    }
    /**
     * Get image
     *
     * @return \ShopBundle\Entity\Images
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Add products
     *
     * @param \ShopBundle\Entity\Products $products
     * @return Categories
     */
    public function addProducts(\ShopBundle\Entity\Products $products)
    {
        $this->products[] = $products;
        return $this;
    }
    /**
     * Remove products
     *
     * @param \ShopBundle\Entity\Products $products
     */
    public function removeProducts(\ShopBundle\Entity\Products $products)
    {
        $this->products->removeElement($products);
    }
    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
    public function __toString()
    {
        return $this->getTitle() ?: '';
    }
    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }
}