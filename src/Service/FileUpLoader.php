<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 24/07/2018
 * Time: 15:56
 */

namespace App\Service;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUpLoader
{
    private $targetDirectory;


    public function  __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file) {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    public function deleteUpload($fileName) {
        $fullFileName = $this->getTargetDirectory() . '/' . $fileName;
        if (file_exists($fullFileName)) {
            unlink($fullFileName);
        }
    }



    /**
     * @return mixed
     */
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

}
