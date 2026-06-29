<?php

namespace App\Factory;

use App\Entity\Review;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ReviewFactory
{
    public function __construct(
        private Security $security,
    ) {
    }

    /**
     * Responsible for creating a fully valid Review instance.
     * */
    public function createFromCurrentUser(): Review
    {
        $review = new Review();

        $user = $this->security->getUser();
        if ($user instanceof UserInterface) {
            $review->setAuthorEmail($user->getUserIdentifier());
        }

        return $review;
    }
}
