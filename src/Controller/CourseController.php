<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Page;
use App\Form\CourseFormType;
use App\Form\LessonFormType;
use App\Form\PageFormType;
use App\Form\WordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CourseController extends AbstractController
{
    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/cursus', name: 'app_course')]
    public function index(Request $request): Response
    {
        $courses = $this->entityManager->getRepository(Course::class)->findAll();
        $course = new Course();

        $form = $this->createForm(CourseFormType::class, $course);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $course = $form->getData();

            $this->entityManager->persist($course);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_course');
        }


        return $this->render('course/index.html.twig', [
            'form' => $form,
            'courses' => $courses,
        ]);
    }

    #[Route('/cursus/{course}', name: 'app_course_view')]
    public function course(Request $request, $course): Response
    {
        $course = $this->entityManager->getRepository(Course::class)->findOneBy(["id" => $course]);
        $lesson = new Lesson();
        $lesson->setCourse($course);

        $form = $this->createForm(LessonFormType::class, $lesson);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lesson = $form->getData();

            $this->entityManager->persist($lesson);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_course');
        }


        return $this->render('course/view.html.twig', [
            'form' => $form,
            'course' => $course,
        ]);
    }

    #[Route('/cursus/{course}/lesson', name: 'app_course_lessons')]
    public function lessons($course): Response
    {
        return $this->render('course/index.html.twig', [
            'controller_name' => 'CourseController',
        ]);
    }

    #[Route('/cursus/{course}/lesson/{lesson}', name: 'app_course_lesson')]
    public function lesson(Request $request, $course, $lesson): Response
    {
        $lesson = $this->entityManager->getRepository(Lesson::class)->findOneBy(["id" => $lesson, "course" => $course]);

        $page = new Page();
        $page->setLesson($lesson);
        $form = $this->createForm(PageFormType::class, $page);
        $lessonForm = $this->createForm(LessonFormType::class, $lesson);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $page = $form->getData();

            $this->entityManager->persist($page);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_course_lesson', [
                "course" => $course,
                "lesson" => $lesson->getId()
            ]);
        }

        $lessonForm->handleRequest($request);
        if ($lessonForm->isSubmitted() && $lessonForm->isValid()) {
            $lesson = $lessonForm->getData();

            $this->entityManager->persist($lesson);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_course_lesson', [
                "course" => $course,
                "lesson" => $lesson->getId(),
            ]);
        }


        return $this->render('course/lesson.html.twig', [
            'lesson' => $lesson,
            'form' => $form,
            'lessonForm' => $lessonForm
        ]);
    }
}
