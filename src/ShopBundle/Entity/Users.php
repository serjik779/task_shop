<?php
namespace ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", indexes={@ORM\Index(name="fk_roles", columns={"role_id"})})
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\UsersRepository")
 */
class Users
{
    /**
     *  @var ArrayCollection|Products[]
     * Many Users have Many Products.
     * @ORM\ManyToMany(targetEntity="Products")
     * @ORM\JoinTable(name="wishlist",
     *      joinColumns={@ORM\JoinColumn(name="users_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="products_id", referencedColumnName="id")}
     * )
     */
    private $products;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    protected $password;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    protected $email;
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50, nullable=true)
     */
    private $phone;
    /**
     * @var Roles
     *
     * @ORM\ManyToOne(targetEntity="Roles")
     */
    private $role;
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
     * Set name
     *
     * @param string $name
     * @return Users
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
    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Set email
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set address
     *
     * @param string $address
     * @return Users
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
     * @return Users
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
     * Set Roles
     *
     * @param \ShopBundle\Entity\Roles $role
     * @return Users
     */
    public function setRole(Roles $role = null)
    {
        $this->role = $role;
        return $this;
    }
    /**
     * Get Roles
     *
     * @return \ShopBundle\Entity\Roles
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return ArrayCollection|Products[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function __construct() {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Add products
     *
     * @param \ShopBundle\Entity\Products $products
     *
     * @return Users
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
}


