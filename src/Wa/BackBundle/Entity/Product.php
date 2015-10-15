<?php

namespace Wa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Wa\BackBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank( message = "Obligatoire" )
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Votre titre fait {{ limit }} caractères c'est trop court - 2 caractères minimum"
     * )
     * @ORM\Column(name="title", type="string", length=150)
     */
    private $title;

    /**
     * @var string
     * @Assert\Length(
     *      max = 500,
     *      maxMessage = "Votre description fait {{ limit }} caractères c'est trop long - 500 caractères maximum"
     * )
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     * @Assert\Type(
     *     type="integer",
     *     message="Cette valeur n'est pas valide {{ value }} et doit être de type {{ type }}."
     * )
     * @ORM\Column(name="quantity", type="integer", options={"default":1})
     */
    private $quantity;

    /**
     * @var float
     * @Assert\Type(
     *     type="float",
     *     message="Cette valeur n'est pas valide {{ value }} et doit être de type {{ type }}."
     * )
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     **/
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Marque")
     * @ORM\JoinColumn(name="marque_id", referencedColumnName="id", nullable=false)
     **/
    private $marque;


    public function __construct(){
        $this->dateCreated = new \DateTime('NOW');
        $this->quantity = 1;
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
     * Set title
     *
     * @param string $title
     *
     * @return Product
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
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Product
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set category
     *
     * @param \Wa\BackBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\Wa\BackBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }


    /**
     * Get category
     *
     * @return \Wa\BackBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set marque
     *
     * @param \Wa\BackBundle\Entity\Marque $marque
     *
     * @return Product
     */
    public function setMarque(\Wa\BackBundle\Entity\Marque $marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return \Wa\BackBundle\Entity\Marque
     */
    public function getMarque()
    {
        return $this->marque;
    }

    public function __toString()
    {
        return $this->title;
    }

}
