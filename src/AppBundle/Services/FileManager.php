<?php
namespace AppBundle\Services;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ExceptionInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\RuntimeException;




class FileManager
{
    private $fs;
    private $usersdir;

    public function __construct($usersdir)
    {
        $this->fs = new Filesystem();
        $this->usersdir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$usersdir;
    }

    public function makeUserFolder($id)
    {
        try
        {
            if (!$this->fs->exists($this->usersdir))
                $this->fs->mkdir($this->usersdir, 0700);
            if(!$this->fs->exists($this->usersdir.DIRECTORY_SEPARATOR.$id))
                $this->fs->mkdir($this->usersdir . DIRECTORY_SEPARATOR .$id, 0700);

            return array("status" => true);
        }
        catch (ExceptionInterface $e)
        {
            return $e->getMessage();
        }
    }

    public function deleteUserFolder($id)
    {
        try
        {
             if($this->fs->exists($this->usersdir.DIRECTORY_SEPARATOR.$id))
                $this->fs->remove($this->usersdir . DIRECTORY_SEPARATOR .$id);

            return array("status" => true);
        }
        catch (ExceptionInterface $e)
        {
            return array("status" => false, "message" => $e->getMessage());
        }
    }

    public function makeProgramSourceFolder($idUser, $name)
    {
        try
        {
            $progfolder =  $this->usersdir.DIRECTORY_SEPARATOR.$idUser.DIRECTORY_SEPARATOR.$name;
            $this->fs->mkdir($progfolder, 0700);
            $this->fs->mkdir($progfolder.DIRECTORY_SEPARATOR.'Output', 0700);

            return array("status" => true, "folder" =>$progfolder);
        }
        catch (ExceptionInterface $e)
        {
            return array("status" => false, "message" => $e->getMessage());
        }
    }

    public function moveProgramSource($folder, $file, $fileName)
    {
        try
        {
            if($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile && $this->fs->exists($folder))
            {
                $file->move($folder, $fileName . ".c");
                $this->fs->chmod($folder . DIRECTORY_SEPARATOR . $fileName . ".c", 0700);
                return array("status" => true, "filename" =>$folder.DIRECTORY_SEPARATOR.$fileName.".c");
            }
            else
                throw new RuntimeException("Cannot move file.");
        }
        catch (ExceptionInterface $e)
        {
            return array("status" => false, "message" => $e->getMessage());
        }
    }

    public function deleteProgramSourceFolder($idUser, $fileName)
    {
        try
        {
            $folder = $this->usersdir.DIRECTORY_SEPARATOR.$idUser.DIRECTORY_SEPARATOR.$fileName;
            if($this->fs->exists($folder))
                $this->fs->remove($folder);

            return array("status" => true);
        }
        catch(ExceptionInterface $e)
        {
            return array("status" => false, "message" => $e->getMessage());
        }
    }

    public function clang($file,$folder)
    {
        try
        {
            $process = new Process('clang -c -g -emit-llvm '.'"'.$file.'"');
            $process->setWorkingDirectory($folder);
            $process->setTimeout(10);
            $process->run();

            if (!$process->isSuccessful())
            {
                throw  new RuntimeException($process->getErrorOutput());
            }

            return array("status" => true, "output" => $process->getOutput(), "erroroutput" => $process->getErrorOutput());

        }
        catch(ExceptionInterface $e)
        {
            return array("status" => false, "message" => $e->getMessage());
        }
    }

    public function lav()
    {
        try
        {

        }
        catch(ExceptionInterface $e)
        {
            return array("status" => false, "message" => $e->getMessage());
        }
    }

    public function processUploadedFile($idUser, $idProgSource, $file)
    {
        try
        {
            $returnObj = $this->makeProgramSourceFolder($idUser, $idProgSource);
            if(!$returnObj['status'])
                throw new RuntimeException("Folder not created.");

            $folder = $returnObj['folder'];
            $returnObj = $this->moveProgramSource($folder,$file,$idProgSource);

            if(!$returnObj['status'])
                throw new RuntimeException("File cannot be moved.");

            $file = $returnObj['filename'];
            $returnObj = $this->clang($file,$folder);

            if(!$returnObj['status'])
                throw new RuntimeException("File cannot be compiled. Error: ".$returnObj['message']);

            return array("status" => true, "message" => "Output: ".$returnObj['output']." Error output: ".$returnObj['erroroutput']);

        }
        catch(ExceptionInterface $e)
        {
            $returnObj = $this->deleteProgramSourceFolder($idUser,$idProgSource);

            if(!$returnObj['status'])
                return array("status" => false, "message" => "Cannot delete program source folder. Error: ".$returnObj['message']);

            return array("status" => false, "message" => $e->getMessage());
;
        }
    }
}