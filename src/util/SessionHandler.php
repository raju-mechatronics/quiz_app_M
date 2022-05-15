<?php

namespace App\util;

use App\Entity\User;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Utils;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionHandler
{
    private $session;
    private $userRepository;

    public function __construct(RequestStack $requestStack, UserRepository $userRepository)
    {
        $this->session = $requestStack->getSession();
        $this->userRepository = $userRepository;
    }

    public function getUser(): ?User
    {
        $email = $this->session->get("email");
        if ($email)
            return $this->userRepository->findOneBy(["email" => $email]);
        return null;
    }

    public function setUser($email)
    {
        $this->session->set("email", $email);
    }

    public function signOut()
    {
        $this->session->remove("email");
    }

}