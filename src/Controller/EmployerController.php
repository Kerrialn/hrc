<?php

namespace App\Controller;

use App\Entity\Resume;
use App\Entity\Vacancy;
use App\Repository\VacancyRepository;
use App\Service\PdfGeneratorSerivce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class EmployerController extends AbstractController
{
  public function __construct(
    private Security $security,
    private PdfGeneratorSerivce $pdfGenerator,
    private VacancyRepository $vacancyRepository
  ) {
  }



  #[Route('employer/dashboard', name: 'employer.dashboard')]
  public function register(): Response
  {
    /**
     * @var User $user
     */
    $user = $this->security->getUser();
    $vacancy = $this->vacancyRepository->findVacancyByUserDefaultResume($user->getDefautResume());
    return $this->render('employer/dashboard.html.twig', [
      'user' => $user,
      'vacancy' => $vacancy
    ]);
  }
}
