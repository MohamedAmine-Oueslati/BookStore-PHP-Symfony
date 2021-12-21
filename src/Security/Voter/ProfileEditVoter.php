<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Profile;
use App\Entity\User;

class ProfileEditVoter extends Voter
{
    protected function supports($attribute, $profile)
    {
        return in_array($attribute, ['PROFILE_EDIT', 'PROFILE_VIEW'])
            && $profile instanceof Profile;
    }

    protected function voteOnAttribute($attribute, $profile, TokenInterface $token)
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }


        switch ($attribute) {
            case 'PROFILE_EDIT':
                return $this->canEdit($profile, $user);
                break;
            case 'PROFILE_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }

    private function canEdit(Profile $profile, User $user): bool
    {
        return $user === $profile->getUser();
    }
}
