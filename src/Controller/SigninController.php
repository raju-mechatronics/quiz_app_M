<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use App\util\SessionHandler;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SigninController extends AbstractController
{
    #[Route('/signin', name: 'app_signin')]
    public function index(Request $request, EntityManagerInterface $em, SessionHandler $sessionHandler, UserRepository $userRepository): Response
    {
        $redirectedForm = $request->query->get('path');
        $error = false;
        if ($request->getMethod() == "POST") {
            $fullName = $request->get("fullName");
            $email = $request->get("email");
            $ip = $request->server->get("REMOTE_ADDR");

            if ($email) {
                $user = $userRepository->findOneBy(["email" => $email]);
                if ($user) {
                    $sessionHandler->setUser($email);
                    return $this->redirect("/");
                }
            }
            if ($fullName && $email) {
                $user = new User();
                $user->setName($fullName);
                $user->setEmail($email);
                $user->setIp($ip);
                $em->persist($user);
                $em->flush();
                $sessionHandler->setUser($email);
                if ($redirectedForm) {
                    return $this->redirect($redirectedForm);
                }
                return $this->redirect("/");
            } else {
                $error = true;
            }
        };
        $referer = $request->headers->get('referer');
        dump($referer);
        return $this->render('signin/index.html.twig', [
            'error' => $error,
        ]);
    }
}
