<?php

namespace App\Controller;

use App\Entity\VariationTypes;
use App\Entity\Word;
use App\Entity\WordVariation;
use App\Form\VariationTypeFormType;
use App\Form\WordFormType;
use App\Form\WordVariationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseController extends AbstractController
{
    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_exercise')]
    public function index(Request $request): Response
    {
        $word = new Word();
        $form = $this->createForm(WordFormType::class, $word);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $word = $form->getData();

            $this->entityManager->persist($word);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_exercise');
        }

        return $this->render('exercise/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/variation/{word}', name: 'app_exercise_variation')]
    public function variation(Request $request, $word): Response
    {
        $word = $this->entityManager->getRepository(Word::class)->findOneBy(["id" => $word]);
        $wordVariation = new WordVariation();
        $wordVariation->setWord($word);

        $form = $this->createForm(WordVariationFormType::class, $wordVariation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $wordVariation = $form->getData();

            $this->entityManager->persist($wordVariation);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_exercise');
        }

        return $this->render('exercise/index.html.twig', [
            'form' => $form,
            "word" => $word
        ]);
    }

    #[Route('/variations', name: 'app_exercise_variations')]
    public function variations(Request $request): Response
    {
        $variationTypes = $this->entityManager->getRepository(VariationTypes::class)->findAll();
        $variationType = new VariationTypes();

        $form = $this->createForm(VariationTypeFormType::class, $variationType);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $variationType = $form->getData();

            $this->entityManager->persist($variationType);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_exercise_variations');
        }

        return $this->render('exercise/variation.html.twig', [
            'form' => $form,
            'variationTypes' => $variationTypes
        ]);
    }

    #[Route('/word/{word}', name: 'app_exercise_word')]
    public function word(Request $request, $word): Response
    {
        $word = $this->entityManager->getRepository(Word::class)->find($word);

        return $this->render('exercise/word.html.twig', [
            'word' => $word,
        ]);
    }
}
