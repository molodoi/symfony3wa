<?php

namespace Wa\BackBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Wa\BackBundle\Validator\AntiGrosMots;

/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="Wa\BackBundle\Repository\BrandRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Brand
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
     * @AntiGrosMots
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=150, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="Wa\BackBundle\Entity\Tag")
     * @ORM\JoinTable(name="brand_tag",
     *      joinColumns={
     *          @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     *      },
     *		inverseJoinColumns={
     *          @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *      }
     *)
     */
    private $tags;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

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
     * @return Brand
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
     * @ORM\PrePersist()
     */
    public function setUpdatedAtValue(){
        $this->setUpdatedAt(new \DateTime('NOW'));
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Brand
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }



    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Brand
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tag
     *
     * @param \Wa\BackBundle\Entity\Tag $tag
     *
     * @return Brand
     */
    public function addTag(\Wa\BackBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Wa\BackBundle\Entity\Tag $tag
     */
    public function removeTag(\Wa\BackBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
