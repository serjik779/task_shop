<?php
namespace ShopBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Products
 *
 * @ORM\Table(name="products", indexes={@ORM\Index(name="fk_category", columns={"category_id"})})
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\ProductsRepository")
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
     * @Gedmo\Slug(fields={"title"})
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
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;
    /**
     * @var ArrayCollection|Images[]
     * Many Products have Many Images.
     * @ORM\ManyToMany(targetEntity="ShopBundle\Entity\Images", mappedBy="products", cascade={"persist"})
     */
    protected $images;
    /**
     * @var boolean
     *
     * @ORM\Column(name="on_main", type="boolean", nullable=false)
     */
    private $onMain = false;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_visible", type="boolean", nullable=false)
     */
    private $isVisible = true;
    /**
     * @var boolean
     *
     * @ORM\Column(name="top", type="boolean", nullable=false)
     */
    private $top = false;
    /**
     * @var ArrayCollection|Products[]
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\OrderItems", mappedBy="products", cascade={"persist"})
     */
    protected $orderItems;

    /**
     * @var Images
     */
    protected $image;

    /**
     * @var = \DateTime
     * @Gedmo\Timestampable(field="created")
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=128, nullable=false, unique=true )
     */
    private $slug;

    /**
     * Products constructor.
     */
    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->images = new ArrayCollection();
    }
    public function addImage(\ShopBundle\Entity\Images $image) {
        $this->images->add($image);
        $image->addProduct($this);
    }
    /**
     * Remove image
     *
     * @param \ShopBundle\Entity\Images $image
     */
    public function removeImage(Images $image)
    {
        $this->images->removeElement($image);
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
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
    /**
     * @return bool
     */
    public function getOnMain()
    {
        return $this->onMain;
    }
    /**
     * @param bool $onMain
     * @return Products
     */
    public function setOnMain($onMain)
    {
        $this->onMain = $onMain;
        return $this;
    }
    /**
     * @return bool
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }
    /**
     * @param bool $isVisible
     * @return Products
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    /**
     * @return bool
     */
    public function getTop(): bool
    {
        return $this->top;
    }

    /**
     * @param bool $top
     */
    public function setTop(bool $top)
    {
        $this->top = $top;
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

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }
}