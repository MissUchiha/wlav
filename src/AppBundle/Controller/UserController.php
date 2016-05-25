<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="read_user_all")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
    */
    public function indexAction()
    {
        try
        {
            $em = $this->getDoctrine()->getEntityManager();

            $users = $em->getRepository('AppBundle:User')->findAll();

            return new JsonResponse($users, 200);
        }
        catch(Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
//        return $this->render('user/index.html.twig', array(
//            'users' => $users,
//        ));
    }

    /**
     * Finds and returns a User entity.
     *
     * @Route("/{id}", name="read_user")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN') or user.getId() == id")
     */
    public function showAction(User $user)
    {
        try
        {
            $usernew = $this->getDoctrine()->getRepository('AppBundle:User')->find($user->getId());

            if(is_null($usernew))
                return new JsonResponse("User doesnt exist". 404);
            else
                return new JsonResponse($usernew, 200);

        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/", name="create_user")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
//        if(!$request->request->get("username") && !$request->request->get("password") && !$request->request->get("email") && !$request->request->get("firstName") && !$request->request->get("lastName") )
//            return new JsonResponse("Error! Wrong parameters.",400);
//        else
        {
            try {
                $user = new User();
                $user->setEmail($request->request->get('email'));
                $user->setPlainPassword($request->request->get('password'));
                $user->setUsername($request->request->get('username'));
                $user->setLastName($request->request->get('lastName'));
                $user->setFirstName($request->request->get('firstName'));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $returnObj = $this->get('app.filemanager')->makeUserFolder($user->getId());
                if(!$returnObj['status'])
                {
                    $this->deleteAction(null, $user);
                    return new JsonResponse("User is not created." . 404);
                }

                if(is_null($user))
                    return new JsonResponse("User is not created.". 404);
                else
                    return new JsonResponse($user, 201);
            }
            catch(\Exception $e)
            {
                return new JsonResponse("Error: ".$e->getMessage().$e->getFile().$e->getLine(),400);
            }
        }

    }

    /**
     * Updates an existing User entity.
     *
     * @Route("/{id}", name="update_user")
     * @Method({"PUT"})
     * @Security("has_role('ROLE_ADMIN') or user.getId() == id")
     */
    public function editAction(Request $request, User $user)
    {
        try
        {
            if($request->request->get("username"))
                $user->setUsername($request->request->get("username"));
            if($request->request->get("password"))
                $user->setPlainPassword($request->request->get("password"));
            if($request->request->get("email"))
                $user->setEmail($request->request->get("email"));
            if($request->request->get("firstName"))
                $user->setFirstName($request->request->get("firstName"));
            if($request->request->get("lastName"))
                $user->setLastName($request->request->get("lastName"));
            if($request->request->get("role") && $request->request->get("role") == 'ROLE_ADMIN')
                $user->setRoles(array($request->request->get("role")));
            else
                $user->removeRole('ROLE_ADMIN');

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            if(is_null($user))
                return new JsonResponse("User doesn't exist.". 404);
            else
                return new JsonResponse($user, 201);
        }
        catch(\Exception $e)
        {
            return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="delete_user")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN') or user.getId() == id")
     */
    public function deleteAction(Request $request,User $user)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $this->get('app.filemanager')->deleteUserFolder($user->getId());
            $em->remove($user);
            $em->flush();

            return new JsonResponse("Deleted user.", 200);
        }
        catch(\Exception $e)
        {
          return new JsonResponse("Error: ".$e->getMessage(),400);
        }
    }

}
