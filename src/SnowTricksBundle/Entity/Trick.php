<?php

namespace SnowTricksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Trick
 *
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass="SnowTricksBundle\Repository\TrickRepository")
 * @UniqueEntity("name")
 */
class Trick
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\Length(min=2)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetimetz")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetimetz", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="SnowTricksBundle\Entity\TricksGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tricksGroup;

    /**
     * @ORM\OneToMany(targetEntity="SnowTricksBundle\Entity\Picture", mappedBy="trick", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $pictures;     

    /**
     * @ORM\OneToMany(targetEntity="SnowTricksBundle\Entity\Picture", mappedBy="trick")
     */
    private $videos; 

    /**
     * @ORM\OneToMany(targetEntity="SnowTricksBundle\Entity\Comment", mappedBy="trick")
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \Datetime("now", new \DateTimeZone('Europe/Paris'));
        $this->pictures = new \Doctrine\Common\Collections\ArrayCollection();
        $this->videos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    } 

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Trick
     */
    public function setName($name)
    {
        $this->name = $name;

        $slug = SELF::slugify($name);
        $this->setSlug($slug);

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
     * Set slug
     *
     * @param string $slug
     *
     * @return Trick
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
     * Set description
     *
     * @param string $description
     *
     * @return Trick
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Trick
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Trick
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set tricksGroup
     *
     * @param \SnowTricksBundle\Entity\TricksGroup $tricksGroup
     *
     * @return Trick
     */
    public function setTricksGroup(\SnowTricksBundle\Entity\TricksGroup $tricksGroup)
    {
        $this->tricksGroup = $tricksGroup;

        return $this;
    }

    /**
     * Get tricksGroup
     *
     * @return \SnowTricksBundle\Entity\TricksGroup
     */
    public function getTricksGroup()
    {
        return $this->tricksGroup;
    }

    /**
     * Add picture
     *
     * @param \SnowTricksBundle\Entity\Picture $picture
     *
     * @return Trick
     */
    public function addPicture(\SnowTricksBundle\Entity\Picture $picture)
    {
        $this->pictures[] = $picture;
        $picture->setTrick($this);

        return $this;
    }

    /**
     * Remove picture
     *
     * @param \SnowTricksBundle\Entity\Picture $picture
     */
    public function removePicture(\SnowTricksBundle\Entity\Picture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Add video
     *
     * @param \SnowTricksBundle\Entity\Picture $video
     *
     * @return Trick
     */
    public function addVideo(\SnowTricksBundle\Entity\Picture $video)
    {
        $this->videos[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param \SnowTricksBundle\Entity\Picture $video
     */
    public function removeVideo(\SnowTricksBundle\Entity\Picture $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Add comment
     *
     * @param \SnowTricksBundle\Entity\Comment $comment
     *
     * @return Trick
     */
    public function addComment(\SnowTricksBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \SnowTricksBundle\Entity\Comment $comment
     */
    public function removeComment(\SnowTricksBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    static public function slugify($text)
    {
      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, '-');

      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
      }

      return $text;
    }
}
