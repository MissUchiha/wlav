<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\ProgramSource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Security("has_role('ROLE_USER') or user.getId() == id")
     */
    public function test1Action(Request $request)
    {
        return new Response("You're logged in. :)"."  ".$request."  ".$this->getUser()->getId());
    }

     /**
      * @Route("/test", name="test")
     */
     public function  testAction(Request $request)
    {
        $user =$this->getDoctrine()->getRepository('AppBundle:User')->find(5);
        $progsorc = $user->getProgramSources();
        $progsorcs = array();
        foreach($progsorc as $item)
            array_push($progsorcs, $item);
        return new JsonResponse($progsorcs);
    }

}
