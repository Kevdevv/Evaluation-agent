<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Form\MissionsTypeUser;
use App\Repository\MissionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/missions')]
class MissionsController extends AbstractController
{
    private $repository;

    public function __construct(MissionsRepository $repository)
    {
        $this->repository = $repository;

    }

    #[Route('/', name: 'app_missions')]
    public function index(): Response
    {
        $user = $this->getUser();
        $nationality = $user->getNationality();
        $speciality = $user->getSpeciality();

        $missions = $this->repository->findVisible($speciality);
        //$missions = $this->repository->findAll();

        return $this->render('missions/index.html.twig', [
            'missions' => $missions,
        ]);
    }

    #[Route('/show/{id}', name: 'app_missions_show', methods: ['GET', 'POST'])]
    public function edit(Request $request, Missions $mission, MissionsRepository $missionsRepository): Response
    {
        $form = $this->createForm(MissionsTypeUser::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $missionsRepository->add($mission, true);

            return $this->redirectToRoute('app_missions', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('missions/show.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }
}
