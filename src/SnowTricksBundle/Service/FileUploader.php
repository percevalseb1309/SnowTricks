<?php

namespace SnowTricksBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    /**
     * 
     * @var string
     * @access private
     */
    private $targetWebPath;
    
    /**
     * 
     * @var string
     * @access private
     */
    private $targetDirectory;

    /**
     * @access public
     * @return void
     */
    public function __construct($targetWebPath, $targetDirectory)
    {
        $this->targetWebPath = $targetWebPath;
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @access public
     * @param UploadedFile $file 
     * @return string
     */
    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    /**
     * @access public
     * @return string
     */
    public function getTargetWebPath()
    {
        return $this->targetWebPath;
    }    

    /**
     * @access public
     * @return string
     */
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}