<?php

namespace AppBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\VerificationCall;
use AppBundle\Form\VerificationCallType;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * VerificationCall controller.
 *
 * @Route("/api")
 */
class VerificationCallController extends Controller
{
    /**
     * Lists all VerificationCall entities from all users.
     *
     * @Route("/verificationcall", name="read_verificationcall_all")
     * @Method("GET")
     */
    /* @Security("has_role('ROLE_ADMIN')") */
    public function indexAction()
    {
        try
        {
            if(!$this->get('app.validationchecker')->checkAdminRole($this->get('security.token_storage')->getToken()->getUser()))
                return new JsonResponse("Access denied.",401);

            $calls = $this->getDoctrine()->getRepository('AppBundle:VerificationCall')->findAll();

            return new JsonResponse($calls, 200);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

    /**
     * Lists all VerificationCall entities from user which id is given.
     *
     * @Route("/user/{iduser}/verificationcall", name="read_verificationcall_userid_all")
     * @Method("GET")
     */

    public function indexUserAction($iduser)
    {
        try
        {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            if((!$user ||  !$this->get('app.validationchecker')->checkUser($user->getId(),$iduser))
                && !$this->get('app.validationchecker')->checkAdminRole($this->get('security.token_storage')->getToken()->getUser()))
                return new JsonResponse("Access denied.",401);

            $calls = $this->getDoctrine()->getRepository('AppBundle:VerificationCall')->getVerificationCallsUser($iduser);

            return new JsonResponse($calls, 200);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

    /**
     * Lists all VerificationCall entities from user and program which ids are given.
     *
     * @Route("/user/{iduser}/programsource/{idprogram}/verificationcall", name="read_verificationcall_userid_programid_all")
     * @Method("GET")
     */
    public function indexUserProgramAction($iduser, $idprogram)
    {
        try
        {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            if((!$user ||  !$this->get('app.validationchecker')->checkUser($user->getId(),$iduser)
                || !$this->get('app.validationchecker')->checkProgram($idprogram,$iduser))
                && !$this->get('app.validationchecker')->checkAdminRole($this->get('security.token_storage')->getToken()->getUser()))
                return new JsonResponse("Access denied.",401);

            $calls = $this->getDoctrine()->getRepository('AppBundle:VerificationCall')->getVerificationCallsProgram($idprogram);

            return new JsonResponse($calls, 200);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }

    }

    /**
     * Finds and returns a VerificationCall entity.
     *
     * @Route("/user/{iduser}/programsource/{idprogram}/verificationcall/{id}", name="read_verificationcall_userid_programid")
     * @Method("GET")
     */
    public function showUserProgramAction($iduser, $idprogram, $id)
    {
        try
        {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            if((!$user ||  !$this->get('app.validationchecker')->checkUser($user->getId(),$iduser)
                    || !$this->get('app.validationchecker')->checkProgram($idprogram,$iduser)
                ||   !$this->get('app.validationchecker')->checkValidationCall($id,$idprogram))
                && !$this->get('app.validationchecker')->checkAdminRole($this->get('security.token_storage')->getToken()->getUser()))
                return new JsonResponse("Access denied.",401);

            $calls = $this->getDoctrine()->getRepository('AppBundle:VerificationCall')->find($id);

            if(is_null($calls))
                    return new JsonResponse("Call doesn't exists.", 404);
            else
                return new JsonResponse($calls, 200);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

    /**
     * Creates a new VerificationCall entity.
     *
     * @Route("/user/{iduser}/programsource/{idprogram}/verificationcall", name="create_verificationcall")
     * @Method("POST")
     */
    public function newAction($iduser, $idprogram, Request $request)
    {
        try
        {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            if((!$user ||  !$this->get('app.validationchecker')->checkUser($user->getId(),$iduser)
                    || !$this->get('app.validationchecker')->checkProgram($idprogram,$iduser))
                && !$this->get('app.validationchecker')->checkAdminRole($this->get('security.token_storage')->getToken()->getUser()))
                return new JsonResponse("Access denied.",401);

            $verificationCall = new VerificationCall();
            $em = $this->getDoctrine()->getManager();
            $progSource = $em->getRepository('AppBundle:ProgramSource')->find($idprogram);
            $flags = array();
            if($request->request->get("flags"))
                $flags = $request->request->get("flags");

            $verificationCall->setFlags((!$flags || count($flags)==0) ? "" : $flags);
            $verificationCall->setProgramSource($progSource);
            $verificationCall->setCreatedAt(new \DateTime());
            $em->persist($verificationCall);
            $em->flush();

            $returnObj = $this->get('app.filemanager')->lav($iduser, $idprogram, $verificationCall->getId(),(!$flags || count($flags)==0) ?  array() : json_decode($flags,true)['flags'] );
            if($returnObj['status'])
            {
                $verificationCall->setStdoutMsg($returnObj['stdout']);
                $verificationCall->setStderrMsg($returnObj['erroroutput']);
                $verificationCall->setStatus($returnObj['statusV']);
                $verificationCall->setOutput($returnObj['output']);
                $em->persist($verificationCall);
                $em->flush();

                return new JsonResponse("Verification call created.",201);
            }
            else
            {
                $em->remove($verificationCall);
                $em->flush();
                return new JsonResponse("Verification call not created. Msg: ".$returnObj["message"],400);

            }

        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }


    /**
     * Deletes a VerificationCall entity.
     *
     * @Route("/user/{iduser}/programsource/{idprogram}/verificationcall/{id}", name="delete_verificationcall")
     * @Method("DELETE")
     */
    public function deleteAction($iduser, $idprogram, $id, Request $request)
    {
        try
        {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            if((!$user
                    ||  !$this->get('app.validationchecker')->checkUser($user->getId(),$iduser)
                    || !$this->get('app.validationchecker')->checkProgram($idprogram,$iduser)
                    ||   !$this->get('app.validationchecker')->checkValidationCall($id,$idprogram))
                && !$this->get('app.validationchecker')->checkAdminRole($user))
                return new JsonResponse("Access denied.",401);

            $em = $this->getDoctrine();
            $call = $em->getRepository('AppBundle:VerificationCall')->find($id);

            if(is_null($call))
                return new JsonResponse("Verification call doesn't exist.", 404);
            $em->getManager()->remove($call);
            $em->getManager()->flush();

//            $returnObj = $this->get('app.filemanager')->deleteVerificationCall($iduser, $idprogram,$id);
//            if($returnObj['status'])
//                return new JsonResponse("Deleted verification call.", 200);
//            else
//                throw new Exception($returnObj["message"]);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }


}
