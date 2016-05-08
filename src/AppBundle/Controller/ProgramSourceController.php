<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ProgramSource;
use AppBundle\Form\ProgramSourceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * ProgramSource controller.
 *
 * @Route("/")
 */
class ProgramSourceController extends Controller
{
    /**
     * Lists all ProgramSource entities.
     *
     * @Route("/programsource", name="read_programsources_all")
     * @Method("GET")
     */
    /* @Security("has_role('ROLE_ADMIN')") */

    public function indexAction()
    {
        try
        {
            $em = $this->getDoctrine()->getManager();

            $programSources = $em->getRepository('AppBundle:ProgramSource')->findAll();

            return new JsonResponse($programSources,200);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

    /**
     * List all programsource entities from user which id is given.
     *
     * @Route("user/{iduser}/programsource" , name="read_programsources_userid_all")
     * @Method("GET")
     */
    public function showAllAction($iduser)
    {
        try
        {
            if(!$this->getUser() ||
                !$this->get('app.validator')->checkUser($this->getUser()->getId(),$iduser))
                return new JsonResponse("",400);

            $em = $this->getDoctrine()->getRepository('AppBundle:ProgramSource');
            $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($iduser);

            if(is_null($user))
                return new JsonResponse("User doesn't exist.",404);

            $progs = $em->findBy(['user' => $user]);

            return new JsonResponse($progs, 200);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

    /**
     * Creates a new ProgramSource entity from user which id is given.
     *
     * @Route("user/{iduser}/programsource", name="create_programsources")
     * @Method("POST")
     */
    public function newAction($iduser, Request $request)
    {
        try
        {
            if(!$this->getUser() || !$this->get('app.validator')->checkUser($this->getUser()->getId(),$iduser))
                return new JsonResponse("",400);

            $programSource = new ProgramSource();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->find($iduser);
            if(is_null($user))
                return new JsonResponse("Error. User doesnt exist". 404);
            $programSource->setUser($user);
            $programSource->setCreatedAt(new \DateTime());
            $em->persist($programSource);
            $em->flush();

            if(is_null($programSource))
                return new JsonResponse("Program source not created.", 404);
            else
                return new JsonResponse($programSource, 201);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }

    }

    /**
     * Finds and returns a ProgramSource entity.
     *
     * @Route("user/{iduser}/programsource/{id}", name="read_programsources_userid")
     * @Method("GET")
     */
    public function showAction($iduser,$id)
    {
        try
        {
            if(!$this->getUser() ||
                !$this->get('app.validator')->checkUser($this->getUser()->getId(), $iduser) ||
                !$this->get('app.validator')->checkProgram($id,$iduser))
                return new JsonResponse("",400);

            $em = $this->getDoctrine()->getRepository('AppBundle:ProgramSource');
            $program = $em->find($id);
            if(is_null($program))
                return new JsonResponse("Program source doesnt exist". 404);
            else
                return new JsonResponse($program, 200);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

    /**
     * Updates existing ProgramSource entity.
     *
     * @Route("/user/{iduser}/programsource/{id}", name="update_programsources_userid")
     * @Method("PUT")
     */
    public function editAction($iduser, $id, Request $request)
    {
        try
        {
            if(!$this->getUser() ||
                !$this->get('app.validator')->checkUser($this->getUser()->getId(),$iduser) ||
                !$this->get('app.validator')->checkProgram($id,$iduser))
                return new JsonResponse("",400);

            $em = $this->getDoctrine()->getRepository('AppBundle:ProgramSource');
            $prog = $em->find($id);

            if(is_null($prog))
                return new JsonResponse("Program source doesn't exist.", 404);

            if($request->request->get("name"))
                $prog->setName($request->request->get("name"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($prog);
            $em->flush();

            if(is_null($prog))
                return new JsonResponse("Program source doesn't exist.", 404);
            else
                return new JsonResponse($prog, 200);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

    /**
     * Deletes a ProgramSource entity.
     *
     * @Route("user/{iduser}/programsource/{id}", name="delete_programsources_userid")
     * @Method("DELETE")
     */
    public function deleteAction($iduser, $id, Request $request)
    {
        try {
            if(!$this->getUser() ||
                !$this->get('app.validator')->checkUser($this->getUser()->getId(),$iduser) ||
                !$this->get('app.validator')->checkProgram($id,$iduser))
                return new JsonResponse("",400);

            $em = $this->getDoctrine();
            $rep = $em->getRepository('AppBundle:ProgramSource');
            $prog = $rep->find($id);

            if(is_null($prog))
                return new JsonResponse("Program source doesn't exist.", 404);

            $em->getManager()->remove($prog);
            $em->getManager()->flush();

            return new JsonResponse("Deleted program source.", 200);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

}
