<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Entity\Teacher;
use App\Repository\MarkRepository;
use App\Repository\PromoRepository;
use App\Repository\StudentRepository;
use App\Repository\SubjectRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageMarksController extends AbstractController
{
    private StudentRepository $studentRepository;
    private SubjectRepository $subjectRepository;
    private TeacherRepository $teacherRepository;

    /**
     * ManageMarksController constructor.
     * @param StudentRepository $studentRepository
     * @param SubjectRepository $subjectRepository
     * @param TeacherRepository $teacherRepository
     */
    public function __construct(StudentRepository $studentRepository, SubjectRepository $subjectRepository,
                                TeacherRepository $teacherRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * @Route("/manage/marks", name="manage_marks")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $teacher = $this->teacherRepository->find($user->getId());
        return $this->render('manage_marks/index.html.twig', [
            'controller_name' => 'ManageMarksController',
            'promos' => $teacher->getPromos(),
            'subjects' => $teacher->getSubjects()
        ]);
    }

    /**
     * @Route("/manage/marks/promo/{id}/students", name="get_students", methods={"GET"})
     */
    public function getStudents($id): JsonResponse
    {
        return new JsonResponse($this->studentRepository->findStudentsByPromo($id));
    }

    /**
     * @Route("/manage/marks/add", name="add_mark", methods={"POST"})
     */
    public function addMark(Request $request): Response
    {
        $studentId =  $request->get('studentId');
        $subjectId =  $request->get('subjectId');
        $markType =  $request->get('markType');
        $markValue =  $request->get('markValue');
        $markCoef =  $request->get('markCoef');
        $markDesc =  $request->get('markDesc');

        $newMark = new Mark();
        $newMark->setStudent($this->studentRepository->find($studentId));
        $newMark->setSubject($this->subjectRepository->find($subjectId));
        $newMark->setType($markType);
        $newMark->setMark($markValue);
        $newMark->setCoef($markCoef);
        $newMark->setDescription($markDesc);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($newMark);
        $manager->flush();

        return new Response("mark added", Response::HTTP_OK);
    }
}
