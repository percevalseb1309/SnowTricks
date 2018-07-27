<?php

namespace SnowTricksBundle\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use SnowTricksBundle\Entity\Picture;
use SnowTricksBundle\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;

class FileUploadSubscriber implements EventSubscriber
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
            'preRemove',
            'postLoad',
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if ( ! $entity instanceof Picture) {
            return;
        }

        $changes = $args->getEntityChangeSet();

        $previousFilename = null;

        if(array_key_exists("file", $changes)){
            $previousFilename = $changes["file"][0];
        }

        if(is_null($entity->getFile())){
            $entity->setFile($previousFilename);
        } 
        else {
            if( ! is_null($previousFilename)){
                $pathPreviousFile = $this->uploader->getTargetDirectory(). "/". $previousFilename;
                if(file_exists($pathPreviousFile)){
                    unlink($pathPreviousFile);
                }
            }
            $this->uploadFile($entity);
        }
    } 

    private function uploadFile($entity)
    {
        if ( ! $entity instanceof Picture) {
            return;
        }

        $file = $entity->getFile();

        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setFile($fileName);
            $alt = $file->getClientOriginalName();
            $entity->setAlt($alt);
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ( ! $entity instanceof Picture) {
            return;
        }

        if (file_exists($entity->getFile())) {
            unlink($entity->getFile());
        }
    }  

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ( ! $entity instanceof Picture) {
            return;
        }

        if ($fileName = $entity->getFile()) {
            $entity->setWebPath('uploads/pictures/'.$fileName);
            $entity->setFile(new File($this->uploader->getTargetDirectory().'/'.$fileName));
        }
    }
}