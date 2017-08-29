<?php
namespace ShopBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Roles
 *
 * @ORM\Table(name="Roles")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\RolesRepository")
 */
class Roles
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
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;
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
     * Set type
     *
     * @param string $type
     * @return Roles
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}