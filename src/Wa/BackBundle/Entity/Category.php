<?php

namespace Wa\BackBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
// Ajoutez ce use pour le contexte
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Wa\BackBundle\Entity\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="title", type="string", length=100)
     * @Assert\Length(min=2)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    public function __construct(){
        $this->dateCreated = new \DateTime('NOW');
        $this->active = true;
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
     * @return Category
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
     * @return Category
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Category
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Category
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @Assert\Callback
     */
    public function isValid(ExecutionContextInterface $context)
    {
        $forbiddenWords = array('catégorie', 'categorie', 'Catégorie', 'Categorie');

        // On vérifie que le contenu ne contient pas l'un des mots
        if (preg_match('#'.implode('|', $forbiddenWords).'#', $this->getDescription())) {
            // La règle est violée, on définit l'erreur
            $context
                ->buildViolation('Contenu invalide car il contient un mot interdit.')
                ->atPath('description')
                ->addViolation()
            ;
        }

        //Le titre doit être en majuscule
        if(!preg_match('/[A-Z]/', $this->getTitle())){
            $context
                ->buildViolation('Tous les caractères de votre titre ne sont pas en majuscules!')
                ->atPath('title')
                ->addViolation()
            ;
        }
    }

    /**
     * @Assert\True(message="La position est 1 le titre doit être ACCUEIL.")
     */
    public function isCategoryValid()
    {
        // On vérifie que le contenu ne contient pas l'un des mots
        if ($this->getPosition() === 1 && $this->getTitle() != "ACCUEIL") {
            return false;
        }

        return true;
    }

}
