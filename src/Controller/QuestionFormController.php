<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Option;
use App\Entity\Question;
use App\util\SessionHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionFormController extends AbstractController
{
    #[Route('/questionform', name: 'app_question_form')]
    public function index(Request $request, SessionHandler $sessionHandler, EntityManagerInterface $em): Response
    {
        $user = $sessionHandler->getUser();

        if ($request->getMethod() == "POST") {
            for ($i = 1; $i <= 10; $i++) {
                $question = new Question();
                $question->setQuestion($request->get("Q" . $i));
                $question->setUser($user);
                $answer = new Answer();
                $answer->setAns($request->get("A" . $i));
                $question->setAnswer($answer);
                $em->persist($question);
                $em->flush();
                dump($question);
                for ($j = 1; $j <= 4; $j++) {
                    $option = new Option();
                    $option->setQuestion($question);
                    $option->setChoiceText($request->get("Q" . $i . "_Option_" . $j));
                    $em->persist($option);
                }
            }
            $em->flush();
            return $this->redirect("/");
        }
        return $this->render('question_form/index.html.twig', [
            'controller_name' => 'QuestionFormController',
        ]);
    }
}
