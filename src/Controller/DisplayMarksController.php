<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use http\Exception\BadMessageException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MarkRepository;
use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;


class DisplayMarksController extends AbstractController
{
    private MarkRepository $markRepository;
    private StudentRepository $studentRepository;
   

    public function __construct(MarkRepository $markRepository,StudentRepository $studentRepository){
        $this->markRepository = $markRepository;
        $this->studentRepository = $studentRepository;

    }

    /**
     * @Route("/display/marks", name="display_marks")
     */
    public function index(): Response
    {
        $student = $this->getUser();
        return $this->render('display_marks/index.html.twig', [
            'student' => $student,
            'controller_name' => 'DisplayMarksController',
            'marks' => $this->markRepository->findBy(array('student' => $student)),

        ]);
    }
    /**
     * @Route("/display/bulletin", name="display_bulletin")
     */
    public function bulletin(Pdf $knpSnappyPdf): Response
    {
        $student = $this->getUser();

      $html= $this->renderView('display_marks/bulletin.html.twig', [
            'student' => $student,
            'controller_name' => 'DisplayMarksController',
            'marks' => $this->markRepository->findBy(array('student' => $student),array('subject'=>'DESC'))
        ]);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'bulletin.pdf'
        );




    }
}
