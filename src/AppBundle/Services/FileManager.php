<?php
namespace AppBundle\Services;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class FileManager
{
    private $fs;
    private $usersdir;

    public function __construct($usersdir)
    {
        $this->fs = new Filesystem();
        $this->usersdir = str_replace(' ', '\ ', $_SERVER['DOCUMENT_ROOT']).DIRECTORY_SEPARATOR.$usersdir;
    }

    public function makeUserFolder($id)
    {
        try
        {
            if (!$this->fs->exists($this->usersdir))
                $this->fs->mkdir($this->usersdir, 0700);
            if(!$this->fs->exists($this->usersdir.DIRECTORY_SEPARATOR.$id))
                $this->fs->mkdir($this->usersdir . DIRECTORY_SEPARATOR .$id, 0700);

            return null;
        }
        catch (\Exception $e)
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

            return null;
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function makeProgramSourceFolder($idUser, $name)
    {
        try
        {
            $progfolder =  $this->usersdir.DIRECTORY_SEPARATOR.$idUser.DIRECTORY_SEPARATOR.$name;
            $this->fs->mkdir($progfolder, 0700);
            $this->fs->mkdir($progfolder.DIRECTORY_SEPARATOR.'Output', 0700);

            return $progfolder;
        }
        catch (\Exception $e)
        {
            return null;
//            return $e->getMessage();
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
                return $folder.DIRECTORY_SEPARATOR.$fileName.".c";
            }
            else
                throw new Exception("Cannot move file.");
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function deleteProgramSourceFolder($idUser, $fileName)
    {
        try
        {
            $folder = $this->usersdir.DIRECTORY_SEPARATOR.$idUser.DIRECTORY_SEPARATOR.$fileName;
            if($this->fs->exists($folder))
                $this->fs->remove($folder);

            return null;
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function clang($file,$folder)
    {
        try
        {
            $process = new Process('clang -c -g -emit-llvm '.$file);
            $process->setWorkingDirectory($folder);
            $process->run();

            if (!$process->isSuccessful())
            {
                throw new ProcessFailedException($process);
            }

            return $process->getExitCode().$process->getWorkingDirectory().$process->getErrorOutput().$process->getOutput();

        }
        catch(Exception $e)
        {
            return null;
        }
    }

    public function processUploadedFile($idUser, $idProgSource, $file)
    {
        try
        {
            $folder = $this->makeProgramSourceFolder($idUser, $idProgSource);
            if(is_null($folder))
                throw new Exception("Folder not created.");

            $file = $this->moveProgramSource($folder,$file,$idProgSource);
            if(is_null($file))
                throw new Exception("File cannot be moved.");

            $msg = $this->clang($file,$folder);
            if(is_null($msg))
                throw new Exception("File cannot be compiled. Error: ".$msg);

            return $msg;
        }
        catch(Exception $e)
        {
            $this->deleteProgramSourceFolder($idUser,$idProgSource);
            return $e->getMessage();
        }
    }
}