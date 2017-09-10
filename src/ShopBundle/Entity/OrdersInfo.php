<?php
namespace ShopBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * OrdersInfo
 *
 * @ORM\Table(name="orders_info", indexes={@ORM\Index(name="fk_delivery_type", columns={"delivery_type_id"})})
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\OrdersInfoRepository")
 */
class OrdersInfo
{
    const PENDING_STATUS = 'Not considered';
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50, nullable=false)
     */
    private $phone;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;
    /**
     * @var ArrayCollection|OrderItems[]
     * @ORM\OneToMany(targetEntity="ShopBundle\Entity\OrderItems", mappedBy="ordersInfo", cascade={"persist"}, orphanRemoval=true)
     */
    protected $orderItems;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status = OrdersInfo::PENDING_STATUS;


    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total = 0;

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return OrdersInfo
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return OrdersInfo
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

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
     * @return ArrayCollection|OrderItems[]
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }
    /**
     * @param ArrayCollection|OrderItems[] $ordersItem
     */
    public function setOrderItems($ordersItem)
    {
        if (count($ordersItem) > 0) {
            foreach ($ordersItem as $oi) {
                $this->addOrderItems($oi);
            }
        }
        return $this;
    }
    public function addOrderItems(OrderItems $orderItems) {
        $orderItems->setOrdersInfo($this);
        $this->orderItems->add($orderItems);
    }
    public function removeOrderItems(OrderItems $orderItems)
    {
        $this->orderItems->removeElement($orderItems);
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
     * Set date
     *
     * @param \DateTime $date
     * @return OrdersInfo
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Set address
     *
     * @param string $address
     * @return OrdersInfo
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * Set phone
     *
     * @param string $phone
     * @return OrdersInfo
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * Set name
     *
     * @param string $name
     * @return OrdersInfo
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    public function __toString()
    {
        return $this->getName() ?: '';
    }
    /**
     * Set deliveryType
     *
     * @param \ShopBundle\Entity\DeliveryType $deliveryType
     * @return OrdersInfo
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
}