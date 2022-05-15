<?php

namespace App\Controller;

use App\Repository\AnswerRepository;
use App\Repository\UserRepository;
use App\util\SessionHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    #[Route('/answer/{id}', name: 'app_answer')]
    public function index(int $id, Request $request, UserRepository $userRepository, SessionHandler $sessionHandler, AnswerRepository $answerRepository): Response
    {
        $answerer = $sessionHandler->getUser();
        $questioner = $userRepository->find($id);

        if ($request->getMethod() == "POST") {
            dump($request->get("Q1"));
            $result = 0;
            for ($i = 1; $i <= 10; $i++) {
                dump($request->get("Q" . $i));
                $isAnswer = $answerRepository->findBy(["ans" => $request->get("Q" . $i)]);
                dump($isAnswer);
                if ($isAnswer) $result++;
            }
            dump($result);
            throw new \Exception();
            return $this->redirect("/result");
        }

        $questions = $questioner->getQuestions();
        foreach ($questions as $question) {
            dump($question->getAnswer());
        }

        return $this->render('answer/index.html.twig', [
            'questioner' => $questioner,
        ]);
    }
}
