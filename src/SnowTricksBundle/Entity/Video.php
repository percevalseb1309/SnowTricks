<?php

namespace SnowTricksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="SnowTricksBundle\Repository\VideoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Video
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
     * @ORM\Column(name="type", type="string", length=16)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="identif", type="string", length=255)
     */
    private $identif;

    /**
    * @var string
    *
    * @Assert\Regex(
    *     pattern="#^(http|https)://(www.youtube.com|www.dailymotion.com|vimeo.com)/#",
    *     match=true,
    *     message="The url must match the url of a Youtube, DailyMotion or Vimeo video"
    * )
    */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetimetz")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="SnowTricksBundle\Entity\Trick", inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \Datetime("now", new \DateTimeZone('Europe/Paris'));
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
     * Set type
     *
     * @param string $type
     *
     * @return Video
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set identif
     *
     * @param string $identif
     *
     * @return Video
     */
    public function setIdentif($identif)
    {
        $this->identif = $identif;

        return $this;
    }

    /**
     * Get identif
     *
     * @return string
     */
    public function getIdentif()
    {
        return $this->identif;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Video
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        if ($this->url === null) {
            return $this->url();
        }
        
        return $this->url;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Video
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
     * Set trick
     *
     * @param \SnowTricksBundle\Entity\Trick $trick
     *
     * @return Video
     */
    public function setTrick(\SnowTricksBundle\Entity\Trick $trick)
    {
        $this->trick = $trick;

        return $this;
    }

    /**
     * Get trick
     *
     * @return \SnowTricksBundle\Entity\Trick
     */
    public function getTrick()
    {
        return $this->trick;
    }

    /**
     * @param string $url
     *
     * @return void
     */
    private function youtubeId($url)
    {
        $array = explode("=", $url);

        $this->setIdentif($array[1]);
        $this->setType('youtube');
    }

    /**
     * @param string $url
     *
     * @return void
     */
    private function dailymotionId($url)
    {
        $case = explode("/", $url);
        $idb = $case[4];
        $bp = explode("_", $idb);
        $id = $bp[0];

        $this->setIdentif($id);
        $this->setType('dailymotion');
    }

    /**
     * @param string $url
     *
     * @return void
     */
    private function vimeoId($url)
    {
        $array = explode("/", $url);
        $id = $array[count($array)-1];

        $this->setIdentif($id);
        $this->setType('vimeo');
    }

    /**
     * @return void
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @ORM\PreFlush()
    */
    public function extractIdentif()
    {
        $url = $this->getUrl();

        if (preg_match("#^(http|https)://www.youtube.com/#", $url)) {
            $this->youtubeId($url);
        } elseif ((preg_match("#^(http|https)://www.dailymotion.com/#", $url))) {
            $this->dailymotionId($url);
        } elseif ((preg_match("#^(http|https)://vimeo.com/#", $url))) {
            $this->vimeoId($url);
        }
    }

    /**
     * @return string
     */
    private function url()
    {
        $control = $this->getType();
        $id = strip_tags($this->getIdentif());

        if ($control == 'youtube') {
            $embed = "https://www.youtube-nocookie.com/embed/".$id;
            return $embed;
        } elseif ($control == 'dailymotion') {
            $embed = "https://www.dailymotion.com/embed/video/".$id;
            return $embed;
        } elseif ($control == 'vimeo') {
            $embed = "https://player.vimeo.com/video/".$id;
            return $embed;
        }
    }

    /**
     * @return string
     */
    public function image()
    {
        $control = $this->getType();
        $id = strip_tags($this->getIdentif());

        if ($control == 'youtube') {
            $image = 'https://img.youtube.com/vi/'. $id. '/hqdefault.jpg';
            return $image;
        } elseif ($control == 'dailymotion') {
            $image = 'https://www.dailymotion.com/thumbnail/150x120/video/'. $id. '' ;
            return $image;
        } elseif ($control == 'vimeo') {
            $hash = unserialize(file_get_contents("https://vimeo.com/api/v2/video/".$id.".php"));
            $image = $hash[0]['thumbnail_small'];
            return $image;
        }
    }

    /**
     * @return string
     */
    public function video()
    {
        $video = "<iframe width='100%' height='100%' src='".$this->url()."'  frameborder='0'  allowfullscreen></iframe>";
        return $video;
    }
}
