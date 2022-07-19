<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Form\MissionsType;
use App\Repository\MissionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/missions')]
class AdminMissionsController extends AbstractController
{
    #[Route('/', name: 'app_admin_missions_index', methods: ['GET'])]
    public function index(MissionsRepository $missionsRepository): Response
    {
        return $this->render('admin_missions/index.html.twig', [
            'missions' => $missionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_missions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MissionsRepository $missionsRepository): Response
    {
        $mission = new Missions();
        $form = $this->createForm(MissionsType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $missionsRepository->add($mission, true);

            return $this->redirectToRoute('app_admin_missions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_missions/new.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_missions_show', methods: ['GET'])]
    public function show(Missions $mission): Response
    {
        return $this->render('admin_missions/show.html.twig', [
            'mission' => $mission,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_missions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Missions $mission, MissionsRepository $missionsRepository): Response
    {
        $form = $this->createForm(MissionsType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $missionsRepository->add($mission, true);

            return $this->redirectToRoute('app_admin_missions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_missions/edit.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_missions_delete', methods: ['POST'])]
    public function delete(Request $request, Missions $mission, MissionsRepository $missionsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mission->getId(), $request->request->get('_token'))) {
            $missionsRepository->remove($mission, true);
        }

        return $this->redirectToRoute('app_admin_missions_index', [], Response::HTTP_SEE_OTHER);
    }
}
