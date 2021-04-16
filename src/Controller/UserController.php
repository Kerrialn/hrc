<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Entity\Pair;
use App\Entity\Resume;
use App\Entity\Vacancy;
use App\Form\ExperienceFormType;
use App\Form\PairFormType;
use App\Form\QualificationFormType;
use App\Form\ResumeFormType;
use App\Repository\ExperienceRepository;
use App\Repository\PairRepository;
use App\Repository\QualificationRepository;
use App\Repository\ResumeRepository;
use App\Repository\VacancyRepository;
use App\Service\FlashMessageService;
use App\Service\PdfGeneratorSerivce;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class UserController extends AbstractController
{
  public function __construct(
    private Security $security,
    private PdfGeneratorSerivce $pdfGenerator,
    private VacancyRepository $vacancyRepository,
    private PairRepository $pairRepository,
    private ResumeRepository $resumeRepository,
    private ExperienceRepository $experienceRepository,
    private QualificationRepository $qualificationRepository
  ) {
  }

  #[Route('/dashboard', name: 'user.dashboard')]
  public function register(Request $request): Response
  {
    /**
     * @var User $user
     */
    $user = $this->security->getUser();
    $resume = $user->getResumes()->first();


    if ($resume) {
      $result = $this->vacancyRepository->findUnpairedVacancyByUserResume($resume);
    }

    $vacancy = $result['vacancy'] ?? null;
    $count = $result['count'] ?? 0;
    /**
     * @var FormInterface $pairForm
     */
    $pairForm = $this->createForm(PairFormType::class);
    $pairForm->handleRequest($request);

    if ($pairForm->isSubmitted() && $pairForm->isValid()) {


      $isLiked = $pairForm->get('likeBtn')->isClicked();
      $resume = $pairForm->get('resume')->getData();

      dump($request);
      die;

      $this->pairRepository->create($user, $vacancy, $isLiked, $resume);
      return new RedirectResponse($this->generateUrl('user.dashboard'));
    }

    return $this->render('user/dashboard.html.twig', [
      'user' => $user,
      'vacancy' => $vacancy,
      'count' => $count,
      'pairForm' => $pairForm->createView()
    ]);
  }

  #[Route('/account', name: 'user.account')]
  public function account(): Response
  {
    $user = $this->security->getUser();
    return $this->render('user/account.html.twig', [
      'user' => $user
    ]);
  }

  #[Route('/matches', name: 'user.matches')]
  public function matches(): Response
  {
    /**
     * @var User $user
     */
    $user = $this->security->getUser();
    $matches = $this->pairRepository->getCandidateMatches($user);
    return $this->render('user/matches.html.twig', [
      'user' => $user,
      'pairs' => $matches
    ]);
  }
}
