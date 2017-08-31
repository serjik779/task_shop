<?php

namespace ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Images
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\ImagesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Images
{

    const SERVER_PATH_TO_IMAGE_FOLDER = '/uploads/';
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
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $filename;
    /**
     * @var ArrayCollection|Products[]
     *
     * @ORM\ManyToMany(targetEntity="ShopBundle\Entity\Products", inversedBy="images", cascade={"persist"})
     * @ORM\JoinTable(name="images_products",
     *     joinColumns={
     *       @ORM\JoinColumn(name="images_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *       @ORM\JoinColumn(name="products_id", referencedColumnName="id")
     *     }
     * )
     */
    protected $products;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @return DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     * @return Images
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }
    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and target filename as params
        $this->getFile()->move(
            $_SERVER['DOCUMENT_ROOT'] . self::SERVER_PATH_TO_IMAGE_FOLDER . date('Y') . '/' . date('m') . '/',
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->filename = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    public function refreshUpdated()
    {
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function lifecycleFileUpload()
    {
        $this->upload();
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set filename
     *
     * @param string $filename
     * @return Images
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Add products
     *
     * @param \ShopBundle\Entity\Products $products
     */
    public function addProduct(\ShopBundle\Entity\Products $products)
    {
        $this->products[] = $products;
        #$products->addImage($this);
    }

    /**
     * Remove products
     *
     * @param \ShopBundle\Entity\Products $products
     */
    public function removeProduct(\ShopBundle\Entity\Products $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function getWebPath() {
        return $_SERVER['DOCUMENT_ROOT'] . Images::SERVER_PATH_TO_IMAGE_FOLDER . date('Y', $this->getUpdated()->getTimestamp()) . '/' . date('m', $this->getUpdated()->getTimestamp()) . '/' . $this->getFilename();
    }

    public function getPath() {
        return '/uploads/' . date('Y', $this->getUpdated()->getTimestamp()) . '/' . date('m', $this->getUpdated()->getTimestamp()) . '/' . $this->getFilename();
    }

    public function __toString()
    {
        return $this->getFilename() ?: '';
    }
}
