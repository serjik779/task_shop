<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderItems
 *
 * @ORM\Table(name="order_items", indexes={@ORM\Index(name="fk_order_info", columns={"order_info_id"}), @ORM\Index(name="fk_delivery_type", columns={"delivery_type_id"}), @ORM\Index(name="fk_product", columns={"product_id"})})
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
     * @var DeliveryType
     *
     * @ORM\ManyToOne(targetEntity="DeliveryType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="delivery_type_id", referencedColumnName="id")
     * })
     */
    private $deliveryType;

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
     * @ORM\ManyToOne(targetEntity="Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;



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
     * Set deliveryType
     *
     * @param \ShopBundle\Entity\DeliveryType $deliveryType
     * @return OrderItems
     */
    public function setDeliveryType(\ShopBundle\Entity\DeliveryType $deliveryType = null)
    {
        $this->deliveryType = $deliveryType;

        return $this;
    }

    /**
     * Get deliveryType
     *
     * @return \ShopBundle\Entity\DeliveryType 
     */
    public function getDeliveryType()
    {
        return $this->deliveryType;
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
     * Set product
     *
     * @param \ShopBundle\Entity\Products $product
     * @return OrderItems
     */
    public function setProduct(\ShopBundle\Entity\Products $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \ShopBundle\Entity\Products 
     */
    public function getProduct()
    {
        return $this->product;
    }
}
