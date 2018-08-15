<?php

namespace SnowTricksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Avatar
 *
 * @ORM\Table(name="avatar")
 * @ORM\Entity(repositoryClass="SnowTricksBundle\Repository\AvatarRepository")
 */
class Avatar
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
     * @ORM\Column(name="file", type="string", length=255, unique=true)
     *
     * @Assert\Image(
     *     maxSize = "1024k",
     *     minWidth = 50,
     *     maxWidth = 800,
     *     minHeight = 50,
     *     maxHeight = 800,
     * )
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\OneToOne(targetEntity="SnowTricksBundle\Entity\User", inversedBy="avatar")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    private $webPath = NULL;


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
     * Set file
     *
     * @param string $file
     *
     * @return Avatar
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
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
     * @return Avatar
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Avatar
     */
    public function setCreated($created)
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
     * Set user
     *
     * @param \SnowTricksBundle\Entity\User $user
     *
     * @return Avatar
     */
    public function setUser(\SnowTricksBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SnowTricksBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getWebPath()
    {
        return $this->webPath;
    }

    public function setWebPath($webPath)
    {
        $this->webPath = $webPath;

        return $this;
    }
}
