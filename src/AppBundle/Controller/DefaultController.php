<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\ProgramSource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\RuntimeException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/test1", name="test1")
     * @param Request $request
     * @return JsonResponse
     * @Security("has_role('ROLE_ADMIN')")
     */
    // or user.getId() == id")
    public function test1Action(Request $request)
    {
        return new JsonResponse("USPEO KUKIIIII");
    }



     /**
      * @Route("/test", name="test")
     */
     public function  testAction(Request $request)
    {
        return new JsonResponse($this->getUser()->getUsername());
        $file = $request->files->get("file");

        $msg = $this->get('app.filemanager')->processUploadedFile(1,2,$file);
        return new JsonResponse($file->getClientOriginalName()." ".$msg['status']."  ".$msg['message']);

        try {
            $process = new Process('sleep 10');

            $process->setTimeout(3);

            $process->run();
            return new JsonResponse("Done");
        }
        catch(RuntimeException $e)
        {
            return new JsonResponse($e->getMessage(),400);

        }


        $this->getParameter("");
        $programSource = new ProgramSource();
        $em = $this->getDoctrine()->getManager();
        $process = new Process('ls -lsa');
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return new JsonResponse($process->getOutput());

        $file = $request->files->get("file");

        if($this->get('app.validationchecker')->checkUploadedFile($file) == true)
            return new JsonResponse($file->getClientOriginalName());

        return new JsonResponse($this->get('app.validator')->test());
    }


    /**
     * @Route("/loggedIn", name="loggedIn")
     */
    public function  loggedInAction(Request $request)
    {
        if($this->getUser())
            return new JsonResponse(array($this->getUser()->getId(), $this->getUser()->getUsername()),200);
        else
            return new JsonResponse(null,404);
    }

    }
