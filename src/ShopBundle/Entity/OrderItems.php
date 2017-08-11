<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderItems
 *
 * @ORM\Table(name="order_items", indexes={@ORM\Index(name="fk_order_info", columns={"id_order_info"}), @ORM\Index(name="fk_delivery_type", columns={"id_delivery_type"})})
 * @ORM\Entity
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
     * @ORM\Column(name="id_service", type="integer", nullable=false)
     */
    private $idService;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float", precision=10, scale=0, nullable=false)
     */
    private $cost;

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
     * @var \DeliveryType
     *
     * @ORM\ManyToOne(targetEntity="DeliveryType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_delivery_type", referencedColumnName="id")
     * })
     */
    private $idDeliveryType;

    /**
     * @var \OrdersInfo
     *
     * @ORM\ManyToOne(targetEntity="OrdersInfo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_order_info", referencedColumnName="id")
     * })
     */
    private $idOrderInfo;



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
     * Set idService
     *
     * @param integer $idService
     * @return OrderItems
     */
    public function setIdService($idService)
    {
        $this->idService = $idService;

        return $this;
    }

    /**
     * Get idService
     *
     * @return integer 
     */
    public function getIdService()
    {
        return $this->idService;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return OrderItems
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
     * Set cost
     *
     * @param float $cost
     * @return OrderItems
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
     * Set idDeliveryType
     *
     * @param \ShopBundle\Entity\DeliveryType $idDeliveryType
     * @return OrderItems
     */
    public function setIdDeliveryType(\ShopBundle\Entity\DeliveryType $idDeliveryType = null)
    {
        $this->idDeliveryType = $idDeliveryType;

        return $this;
    }

    /**
     * Get idDeliveryType
     *
     * @return \ShopBundle\Entity\DeliveryType 
     */
    public function getIdDeliveryType()
    {
        return $this->idDeliveryType;
    }

    /**
     * Set idOrderInfo
     *
     * @param \ShopBundle\Entity\OrdersInfo $idOrderInfo
     * @return OrderItems
     */
    public function setIdOrderInfo(\ShopBundle\Entity\OrdersInfo $idOrderInfo = null)
    {
        $this->idOrderInfo = $idOrderInfo;

        return $this;
    }

    /**
     * Get idOrderInfo
     *
     * @return \ShopBundle\Entity\OrdersInfo 
     */
    public function getIdOrderInfo()
    {
        return $this->idOrderInfo;
    }
}
