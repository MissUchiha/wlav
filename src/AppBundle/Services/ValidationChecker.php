<?php

namespace AppBundle\Services;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ValidationChecker
{
    protected $authorizationChecker;
    protected $em;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, \Doctrine\ORM\EntityManager $em)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->em = $em;
    }


    public function checkUser($idLogged, $idRequested)
    {
        $user = $this->em->getRepository('AppBundle:User')->find($idRequested);
        if(!is_null($user) &&
            ($this->authorizationChecker->isGranted('ROLE_ADMIN') ||
            ($this->authorizationChecker->isGranted('ROLE_USER') && $idLogged==$idRequested)))
            return true;
        else
            return false;
    }

    public function checkProgram($idProgram, $idUser)
    {
        $program = $this->em->getRepository('AppBundle:ProgramSource')->find($idProgram);
        if(!is_null($program) &&
            ($program->getUser()->getId() == $idUser))
            return true;
        else
            return false;

    }

    public function checkValidationCall($idCall, $idProgram)
    {
        $call = $this->em->getRepository('AppBundle:VerificationCall')->find($idCall);
        if(!is_null($call) &&
            ($call->getProgramSource()->getId() == $idProgram))
            return true;
        else
            return false;
    }

    public function checkUploadedFile($file)
    {
        if($file->getClientOriginalExtension() != 'c' || $file->getClientMimeType() != 'text/x-csrc')
            return false;
        else
            return true;
    }
}