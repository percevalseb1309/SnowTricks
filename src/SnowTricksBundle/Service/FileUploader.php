<?php

namespace SnowTricksBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetWebPath;
    private $targetDirectory;

    public function __construct($targetWebPath, $targetDirectory)
    {
        $this->targetWebPath = $targetWebPath;
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    public function getTargetWebPath()
    {
        return $this->targetWebPath;
    }    

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}