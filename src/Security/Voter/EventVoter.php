<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class EventVoter extends Voter
{   
    const ATTRIBUTES = ['EVENT_FORM'];
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        if(in_array($attribute, self::ATTRIBUTES)){
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if($subject instanceof Event ){
            //Conditions pour l'edit
            if($subject->getOwner() === $user){
                return true;
            }

            if($this->security->isGranted('ROLE_USER')){
                return true;
            }
        }else{
            //Condition pour le new
            if($this->security->isGranted('ROLE_USER')){
                return true;
            }
        }

        return false;
    }
}
