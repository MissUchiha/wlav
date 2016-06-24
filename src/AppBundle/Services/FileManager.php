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

    public function renameVerificationCall($folder, $filename, $idVerCall )
    {
        try
        {
            if(!file_exists($folder.DIRECTORY_SEPARATOR.$filename.".txt"))
                throw  new RuntimeException("Error: verification call file not exists! ");

            if(!rename($folder.DIRECTORY_SEPARATOR.$filename.".txt", $folder.DIRECTORY_SEPARATOR.$filename."_{$idVerCall}.txt"))
                throw  new RuntimeException("Error: cannot rename verification call file! ");

            $this->fs->chmod($folder.DIRECTORY_SEPARATOR.$filename."_{$idVerCall}.txt", 0700);

            return array("status" => true, "filename" => $folder.DIRECTORY_SEPARATOR.$filename."_{$idVerCall}.txt");
        }
        catch(ExceptionInterface $e)
        {
            return array("status" => false, "message" => $e->getMessage());
        }
    }


    public function lav($idUser, $idProgSource, $idVerCall, $flags)
    {
        try
        {
            $progFolder =$this->usersdir.DIRECTORY_SEPARATOR.$idUser.DIRECTORY_SEPARATOR.$idProgSource;
            $progName = $progFolder.DIRECTORY_SEPARATOR.$idProgSource.'.o';

            if(!file_exists($progName))
               return array("status" => false, "message" => "Error: program source {$idProgSource} doesn't exist!");


            $lavFlags = " ";

            if(isset($flags['check-assert']))
                $lavFlags += "-check-assert ";
            if(isset($flags['starting-function']))
                $lavFlags += "-starting-function=".$flags['starting-function']." ";
            if(isset($flags['timeout']))
                $lavFlags += "-timeout=".intval($flags['timeout'])." ";

//            $process = new Process('LAV '.'"'.$progName.'"'.$lavFlags);
            $process = new Process('ls');
            $process->setWorkingDirectory($progFolder);
            $process->setTimeout(10);
            $process->run();

            if (!$process->isSuccessful())
            {
                throw  new RuntimeException($process->getErrorOutput());
            }

            $returnObj = $this->renameVerificationCall($progFolder.DIRECTORY_SEPARATOR."Output", $idProgSource, $idVerCall);

//            if(!$returnObj['status'])
//                throw  new RuntimeException($returnObj['message']);

            $statusV = "";
            $filecontents = "";
            if(file_exists($returnObj['filename']))
            {
                $filecontents = file_get_contents($returnObj['filename']);

                $statusV = (strstr($filecontents, "UNSAFE") || strstr($filecontents,"UNCHECKED") || strstr($filecontents,"FAILED")) ? "false" : "true";
            }

            return array("status" => true, "statusV" => $statusV,"output" => $process->getOutput(), "erroroutput" => $process->getErrorOutput(),"output" => $filecontents);
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

    public function getProgSourceContents($idUser,$idProgSource)
    {
        try
        {
            $file = $this->usersdir.DIRECTORY_SEPARATOR.$idUser.DIRECTORY_SEPARATOR.$idProgSource.DIRECTORY_SEPARATOR.$idProgSource.".c";
            $source = "";

            if(file_exists($file))
                $source = file_get_contents($file);

            return array("status" => true, 'source' => $source);
        }
        catch(ExceptionInterface $e)
        {
            return array("status" => false, "message" => $e->getMessage());
        }
    }


}