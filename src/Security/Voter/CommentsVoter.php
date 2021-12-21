<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Comments;
use App\Entity\User;

class CommentsVoter extends Voter
{
    protected function supports($attribute, $comment)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['COMMENT_EDIT', 'COMMENT_DELETE'])
            && $comment instanceof Comments;
    }

    protected function voteOnAttribute($attribute, $comment, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'COMMENT_EDIT':
                return $this->canEdit($comment, $user);
                break;
            case 'COMMENT_DELETE':
                return $this->canDelete($comment, $user);
                break;
        }

        return false;
    }

    private function canEdit(Comments $comment, User $user): bool
    {
        return $user === $comment->getAuthor();
    }

    private function canDelete(Comments $comment, User $user): bool
    {
        return $user === $comment->getAuthor();
    }
}
