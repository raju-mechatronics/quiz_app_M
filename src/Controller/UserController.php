<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\util\SessionHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(SessionHandler $sessionHandler): Response
    {

        $user = $sessionHandler->getUser();
        if ($user) {
            dump($user);
            if (!count($user->getQuestions())) {
                return $this->render('user/index.html.twig', [
                    'newMember' => true,
                    'user' => $user
                ]);
            } else {

            }
        } else {
            $sessionHandler->signOut();
            return $this->redirect("/signin");
        }
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'newMember' => false,
        ]);
    }
}
