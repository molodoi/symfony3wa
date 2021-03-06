<?php

namespace Wa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wa\BackBundle\Repository\TagRepository")
 */
class Tag
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
     *
     * @ORM\Column(name="title", type="string", length=150)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="Brand", mappedBy="tags")
     * @ORM\JoinTable(name="brand_tag")
     **/
    private $brands;

    public function __construct() {
        $this->brands = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Tag
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
     * Add brand
     *
     * @param \Wa\BackBundle\Entity\Brand $brand
     *
     * @return Tag
     */
    public function addBrand(\Wa\BackBundle\Entity\Brand $brand)
    {
        $this->brands[] = $brand;

        $brand->addTag($this);

        return $this;
    }

    /**
     * Remove brand
     *
     * @param \Wa\BackBundle\Entity\Brand $brand
     */
    public function removeBrand(\Wa\BackBundle\Entity\Brand $brand)
    {
        $this->brands->removeElement($brand);
    }

    /**
     * Get brands
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBrands()
    {
        return $this->brands;
    }
}
