<?php
namespace ShopBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * DeliveryType
 *
 * @ORM\Table(name="delivery_type")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\DeliveryTypeRepository")
 */
class DeliveryType
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
     * @var float
     *
     * @ORM\Column(name="cost", type="float", precision=10, scale=0, nullable=false)
     */
    private $cost;
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
     * @return DeliveryType
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
     * @return DeliveryType
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
    public function __toString()
    {
        return $this->getTitle() ?: '';
    }
}