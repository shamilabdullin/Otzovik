<?php


namespace App\Service;


use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManagerService implements FileManagerServiceInterface
{

    private $productImageDirectory;

    public function __construct($productImageDirectory)
    {
        $this->productImageDirectory = $productImageDirectory;
    }

    /**
     * @return mixed
     */
    public function getProductImageDirectory()
    {
        return $this->productImageDirectory;
    }

    public function imageProductUpload(UploadedFile $file): string
    {
        $fileName = uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getProductImageDirectory(), $fileName);
        }catch (FileException $exception){
            return $exception;
        }
        return $fileName;
    }

    public function removeProductImage(string $fileName)
    {
        $fileSystem = new Filesystem();
        $fileImage = $this->getProductImageDirectory().''.$fileName;
        try {
            $fileSystem->remove($fileImage);
        }
        catch (IOExceptionInterface $exception){
            echo $exception->getMessage();
        }
    }
}