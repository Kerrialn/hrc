<?php

namespace App\Controller;

use App\Entity\Resume;
use App\Entity\Vacancy;
use App\Form\ExperienceFormType;
use App\Form\QualificationFormType;
use App\Form\ResumeFormType;
use App\Repository\ResumeRepository;
use App\Repository\VacancyRepository;
use App\Service\FlashMessageService;
use App\Service\PdfGeneratorSerivce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class ResumeController extends AbstractController
{
  public function __construct(
    private Security $security,
    private PdfGeneratorSerivce $pdfGenerator,
    private VacancyRepository $vacancyRepository,
    private ResumeRepository $resumeRepository
  ) {
  }


  #[Route('/resumes', name: 'user.resumes')]
  public function resumes(): Response
  {
    /**
     * @var User $user
     */
    $user = $this->security->getUser();
    return $this->render('user/resume/index.html.twig', [
      'user' => $user
    ]);
  }


  #[Route('/resume/show/{id}', name: 'user.resume.show')]
  public function resume(Resume $resume): Response
  {
    $user = $this->security->getUser();
    return $this->render('user/resume.html.twig', [
      'user' => $user,
      'resume' => $resume
    ]);
  }

  #[Route('/resume/edit/{id}', name: 'user.resume.edit')]
  public function editResume(Resume $resume, Request $request): Response
  {
    $user = $this->security->getUser();
    $resumeForm = $this->createForm(ResumeFormType::class, $resume);
    $resumeForm->handleRequest($request);

    if ($resumeForm->isSubmitted() && $resumeForm->isValid()) {
      $this->resumeRepository->save($resume);
      $this->addFlash(FlashMessageService::TYPE_SUCCESS, FlashMessageService::MESSAGE_CHANGES_SAVED);

      return new RedirectResponse($this->generateUrl('user.resume.edit', ['id' => $resume->getId()]));
    }

    return $this->render('user/resume/edit.html.twig', [
      'user' => $user,
      'resume' => $resume,
      'resumeForm' => $resumeForm->createView()
    ]);
  }

  #[Route('/resume/add/{id}/experience', name: 'user.resume.add.experience')]
  public function resumeAddExperience(Resume $resume, Request $request): Response
  {

    $user = $this->security->getUser();
    $experienceForm = $this->createForm(ExperienceFormType::class);
    $experienceForm->handleRequest($request);

    if ($experienceForm->isSubmitted() && $experienceForm->isValid()) {
      /**
       * @var Experience $experienceData
       */
      $experienceData = $experienceForm->getData();
      $this->experienceRepository->create($experienceData, $resume);

      $this->addFlash(FlashMessageService::TYPE_SUCCESS, FlashMessageService::MESSAGE_CHANGES_SAVED);

      return new RedirectResponse($this->generateUrl('user.resume.edit', ['id' => $resume->getId()]));
    }

    return $this->render('user/resume/parts/experience.html.twig', [
      'user' => $user,
      'resume' => $resume,
      'experienceForm' => $experienceForm->createView()
    ]);
  }

  #[Route('/resume/add/{id}/qualification', name: 'user.resume.add.qualification')]
  public function resumeAddQualifications(Resume $resume, Request $request): Response
  {

    $user = $this->security->getUser();
    $qualificationForm = $this->createForm(QualificationFormType::class);
    $qualificationForm->handleRequest($request);

    if ($qualificationForm->isSubmitted() && $qualificationForm->isValid()) {
      /**
       * @var Qualification $experienceData
       */
      $qualificationData = $qualificationForm->getData();
      $this->qualificationRepository->create($qualificationData, $resume);

      $this->addFlash(FlashMessageService::TYPE_SUCCESS, FlashMessageService::MESSAGE_CHANGES_SAVED);

      return new RedirectResponse($this->generateUrl('user.resume.edit', ['id' => $resume->getId()]));
    }

    return $this->render('user/resume/parts/qualification.html.twig', [
      'user' => $user,
      'resume' => $resume,
      'qualificationForm' => $qualificationForm->createView()
    ]);
  }


  #[Route('/resume/update/{id}', name: 'user.resume.update')]
  public function resumeSetDefault(Resume $resume): RedirectResponse
  {
    /**
     * @var User $user
     */
    $user = $this->security->getUser();
    $this->resumeRepository->setDefualt($resume);
    $this->addFlash(FlashMessageService::TYPE_SUCCESS, FlashMessageService::MESSAGE_CHANGES_SAVED);

    return new RedirectResponse($this->generateUrl('user.resumes'));
  }


  #[Route('/resume/create', name: 'user.resume.create')]
  public function createResume(Request $request): Response
  {
    $user = $this->security->getUser();
    $resumeForm = $this->createForm(ResumeFormType::class);
    $resumeForm->handleRequest($request);

    if ($resumeForm->isSubmitted() && $resumeForm->isValid()) {

      /**
       * @var Resume $resume
       */
      $resume = $resumeForm->getData();
      $this->resumeRepository->create($user, $resume);
      $this->addFlash(FlashMessageService::TYPE_SUCCESS, FlashMessageService::MESSAGE_CHANGES_SAVED);

      return new RedirectResponse($this->generateUrl('user.dashboard'));
    }

    return $this->render('user/resume/create.html.twig', [
      'user' => $user,
      'resumeForm' => $resumeForm->createView()
    ]);
  }

  #[Route('/resume/download/{id}', name: 'user.resume.download')]
  public function resumeDownload(Resume $resume): Response
  {
    $user = $this->security->getUser();
    $html = $this->renderView('user/resume.html.twig', [
      'user' => $user,
      'resume' => $resume
    ]);

    $this->pdfGenerator->generatePdfFromHtml($html);
    return new RedirectResponse($this->urlGenerator->generate('user.resume.show', $resume->getId()));
  }
}
