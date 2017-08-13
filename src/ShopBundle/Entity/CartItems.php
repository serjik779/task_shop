<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartItems
 *
 * @ORM\Table(name="cart_items", indexes={@ORM\Index(name="fk_cart", columns={"cart_id"}), @ORM\Index(name="fk_cart_product", columns={"product_id"})})
 * @ORM\Entity
 */
class CartItems
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
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var integer
     *
     * @ORM\Column(name="discount", type="integer", nullable=false)
     */
    private $discount;

    /**
     * @var Cart
     *
     * @ORM\ManyToOne(targetEntity="Cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     * })
     */
    private $cart;

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
     * Set amount
     *
     * @param integer $amount
     * @return CartItems
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
     * Set discount
     *
     * @param integer $discount
     * @return CartItems
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
     * Set cart
     *
     * @param \ShopBundle\Entity\Cart $cart
     * @return CartItems
     */
    public function setCart(\ShopBundle\Entity\Cart $cart = null)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \ShopBundle\Entity\Cart 
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set product
     *
     * @param \ShopBundle\Entity\Products $product
     * @return CartItems
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
