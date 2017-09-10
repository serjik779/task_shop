<?php
namespace ShopBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * OrderItems
 *
 * @ORM\Table(name="order_items", indexes={@ORM\Index(name="fk_order_info", columns={"order_info_id"}), @ORM\Index(name="fk_product", columns={"product_id"})})
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\OrderItemsRepository")
 */
class OrderItems
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
     * @var integer
     *
     * @ORM\Column(name="discount", type="integer", nullable=true)
     */
    private $discount;
    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;
    /**
     * @var OrdersInfo
     *
     * @ORM\ManyToOne(targetEntity="OrdersInfo", inversedBy="orderItems", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_info_id", referencedColumnName="id")
     * })
     */
    private $ordersInfo;
    /**
     * @var Products
     *
     * @ORM\ManyToOne(targetEntity="Products", inversedBy="orderItems", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $products;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float", precision=10, scale=0, nullable=false)
     */
    private $cost = 0;

    /**
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     * @return OrderItems
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    public function __construct()
    {
        $this->products = new Products();
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
     * Set discount
     *
     * @param integer $discount
     * @return OrderItems
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }
    /**
     * Get discount
     *
     * @return integer
     */
    public function getDiscount()
    {
        return $this->discount;
    }
    /**
     * Set amount
     *
     * @param integer $amount
     * @return OrderItems
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
     * Set ordersInfo
     *
     * @param \ShopBundle\Entity\OrdersInfo $ordersInfo
     * @return OrderItems
     */
    public function setOrdersInfo(\ShopBundle\Entity\OrdersInfo $ordersInfo = null)
    {
        $this->ordersInfo = $ordersInfo;
        return $this;
    }
    /**
     * Get ordersInfo
     *
     * @return \ShopBundle\Entity\OrdersInfo
     */
    public function getOrdersInfo()
    {
        return $this->ordersInfo;
    }
    /**
     * Set products
     *
     * @param \ShopBundle\Entity\Products $products
     * @return OrderItems
     */
    public function setProducts(Products $products = null)
    {
        $this->products = $products;
        return $this;
    }

    public function addProduct(Products $product) {
        $this->setProducts($product);
    }
    /**
     * Get products
     *
     * @return \ShopBundle\Entity\Products
     */
    public function getProducts()
    {
        return $this->products;
    }
}