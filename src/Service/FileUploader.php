<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file)
    {
        $origineFile = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFile = $this->slugger->slug($origineFile);
        $newFile = $safeFile.'-'.uniqid().'.'.$file->guessExtension();

        // Move the file to the directory where brochures ares stored
        try {
            $file->move($this->getTargetDirectory(), $newFile);
        } catch (FileException $exception) {
            throw new FileException("L'image n'a pas été correctement supprimée!");
        }
        return $newFile;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}