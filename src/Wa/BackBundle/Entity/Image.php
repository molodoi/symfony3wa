<?php

namespace Wa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="Wa\BackBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="caption", type="string", length=255)
     */
    private $caption;

    //File va récupérer le fichier

    /**
     * @Assert\File(
     *     maxSize = "500k",
     *     mimeTypes = {"image/jpeg", "image/png", "image/gif"},
     *     mimeTypesMessage = "Please upload a valid Iamge type jpeg, png, gif"
     * )
     */
    private $file;

    private $oldName;

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
     * @return Image
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
     * Set path
     *
     * @param string $path
     *
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set caption
     *
     * @param string $caption
     *
     * @return Image
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param mixed $file
     *
     * @return File
     */
    public function setFile(UploadedFile $file)
    {

        $this->file = $file;

        if($this->path != null){

            $this->oldName = $this->path;

            $this->path = 'lmkfd';

        }

        return $this;
    }

    public function webPath($thumbs = null){

        if(!empty($thumbs)){
            if(file_exists($this->getUploadDir().$thumbs.$this->path)){
                return $this->getUploadDir().$thumbs.$this->path;
            }
        }
        return $this->getUploadDir().$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/categories/';
    }

    protected $thumbnails = array(
            'thumb-100-100-' => array(100,100),
            'thumb-400-400-' => array(400,400),
            'thumb-800-800-' => array(800,800),
        );

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function upload()
    {
        //upload de l'image

        //die('code de suppression');
        if($this->file == null)
            return;

        $extension = $this->file->guessExtension();

        $nameImage = uniqid().'.'.$extension;

        $this->file->move(
            //__DIR__.'/../../../../web/uploads/categories/',
            $this->getUploadRootDir(),
            $nameImage
        );

        $this->path = $nameImage;

        // Creation des thumbnails
        $imagine = new \Imagine\Gd\Imagine();
        $imagineOpen = $imagine->open($this->getUploadRootDir().$nameImage);
        //REDIMENSIONNE ET GARDE LES PROPORTIONS
        $mode1    = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        //REDIMENSIONNE ET CROP
        $mode2    = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

        foreach ($this->thumbnails as $key => $value ){
            $imagineOpen->thumbnail(
                new \Imagine\Image\Box(
                    $value[0],
                    $value[1]
                ),
                $mode1
            )
            ->save($this->getUploadRootDir().$key.$nameImage);
        }

        //suppression de l'ancienne image
        if(!empty($this->oldName)){
            if(file_exists($this->getUploadRootDir().$this->oldName)){
                unlink($this->getUploadRootDir().$this->oldName);
            }
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveFile(){

    }

    /**
     * @ORM\PostRemove()
     */
    public function removeFile(){
        //die(dump($this->getUploadRootDir().$this->path));
        //suppression de l'ancienne image

        if(file_exists($this->getUploadRootDir().$this->path)){
            unlink($this->getUploadRootDir().$this->path);
        }

        foreach($this->thumbnails as $nameThumb => $size)
        {
            if (file_exists($this->getUploadRootDir().$nameThumb.$this->path))
            {
                //unlink($this->getUploadRootDir().$nameThumb.$this->path);
                unlink($this->getUploadRootDir().$nameThumb.$this->path);
            }
        }
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @Assert\Callback
     */
    public function isValide(ExecutionContextInterface $context)
    {

        if ($this->file != null && $this->caption == null)  {
            $context->buildViolation('Tu dois insérer un caption')
                ->atPath('caption')
                ->addViolation();
        }
    }

}

