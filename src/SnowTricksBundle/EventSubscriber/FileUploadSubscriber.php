<?php

namespace SnowTricksBundle\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use SnowTricksBundle\Entity\Picture;
use SnowTricksBundle\Entity\Avatar;
use SnowTricksBundle\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;

class FileUploadSubscriber implements EventSubscriber
{
    /**
     * 
     * @var FileUploader
     * @access private
     */
    private $uploader;

    /**
     * @access public
     * @param FileUploader $uploader 
     * @return void
     */
    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * @access public
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
            'preRemove',
            'postLoad',
        );
    }

    /**
     * @access public
     * @param LifecycleEventArgs $args 
     * @return void
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ( ! $entity instanceof Picture && ! $entity instanceof Avatar) {
            return;
        }

        $this->uploadFile($entity);
    }

    /**
     * @access public
     * @param PreUpdateEventArgs $args 
     * @return void
     */
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

    /**
     * @access public
     * @param Picture|Avatar $entity 
     * @return void
     */
    private function uploadFile($entity)
    {
        if ( ! $entity instanceof Picture && ! $entity instanceof Avatar) {
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

    /**
     * @access public
     * @param LifecycleEventArgs $args 
     * @return void
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ( ! $entity instanceof Picture && ! $entity instanceof Avatar) {
            return;
        }

        if (file_exists($entity->getFile())) {
            unlink($entity->getFile());
        }
    }  

    /**
     * @access public
     * @param LifecycleEventArgs $args 
     * @return void
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ( ! $entity instanceof Picture && ! $entity instanceof Avatar) {
            return;
        }

        if ($fileName = $entity->getFile()) {
            $entity->setWebPath($this->uploader->getTargetWebPath().'/'.$fileName);
            if ($entity instanceof Picture) {
                $entity->setFile(new File($this->uploader->getTargetDirectory().'/'.$fileName));
            }
        }
    }
}