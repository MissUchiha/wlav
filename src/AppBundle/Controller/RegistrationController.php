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
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

/**
 * Registration controller.
 */
class RegistrationController extends Controller
{
    /**
    * @Route("/register", name="register")
    * @Method("POST")
    */
    public function registerAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        
        if($this->get('app.validationchecker')->checkRegistrationParams($request))
        {
            $user = $userManager->createUser();
            $user->setEmail($request->request->get('email'));
            $user->setPlainPassword($request->request->get('password'));
            $user->setUsername($request->request->get('username'));
            $user->setLastName($request->request->get('lastName'));
            $user->setFirstName($request->request->get('firstName'));
            $user->setEnabled(true);
            $user->addUserRole();
    
            $userManager->updateUser($user);
    
            $returnObj = $this->get('app.filemanager')->makeUserFolder($user->getId());
                
            if($returnObj['status'])
                return new JsonResponse("User created.", 201);
            else
                return new JsonResponse(array('message'=>$returnObj['message']),400);
        }
        return new JsonResponse(array('message'=>'Invalid form.'),400);
    }

}
