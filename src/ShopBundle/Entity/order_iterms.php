<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * order_iterms
 *
 * @ORM\Table(name="order_iterms")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\order_itermsRepository")
 */
class order_iterms
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
     * @var int
     *
     * @ORM\Column(name="system_id", type="integer")
     */
    private $systemId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float")
     */
    private $cost;

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="float")
     */
    private $discount;

    /**
     * @var order_info
     *
     * @ORM\OneToOne(targetEntity="ShopBundle\Entity\order_info")
     * @ORM\JoinColumn(name="id_order_info", referencedColumnName="id")
     */
    private $idOrderInfo;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var delivery_type
     *
     * @ORM\OneToOne(targetEntity="ShopBundle\Entity\delivery_type")
     * @ORM\JoinColumn(name="id_delivery_type", referencedColumnName="id")
     */
    private $idDeliveryType;


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
     * Set systemId
     *
     * @param integer $systemId
     * @return order_iterms
     */
    public function setSystemId($systemId)
    {
        $this->systemId = $systemId;

        return $this;
    }

    /**
     * Get systemId
     *
     * @return integer
     */
    public function getSystemId()
    {
        return $this->systemId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return order_iterms
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
     * @return order_iterms
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
     * @param float $discount
     * @return order_iterms
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @return order_info
     */
    public function getIdOrderInfo()
    {
        return $this->idOrderInfo;
    }

    /**
     * @param order_info $idOrderInfo
     * @return self
     */
    public function setIdOrderInfo($idOrderInfo)
    {
        $this->idOrderInfo = $idOrderInfo;
    }


    /**
     * Set amount
     *
     * @param integer $amount
     * @return order_iterms
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
     * @return delivery_type
     */
    public function getIdDeliveryType()
    {
        return $this->idDeliveryType;
    }

    /**
     * @param delivery_type $idDeliveryType
     * @return self
     */
    public function setIdDeliveryType($idDeliveryType)
    {
        $this->idDeliveryType = $idDeliveryType;
    }

}
