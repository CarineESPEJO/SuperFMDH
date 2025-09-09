<?php
/*
namespace App\Twig;

use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class UsersGlobals extends AbstractExtension implements GlobalsInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getGlobals(): array
    {
        $user = $this->security->getUser();

        return [
            'isLoggedIn' => $user !== null,
            'userId'     => $user ? $user->getId() : null,
            'userRole'   => $user ? $user->getRoles()[0] : null,
            'userEmail'  => $user ? $user->getUserIdentifier() : null,
        ];
    }
}*/
