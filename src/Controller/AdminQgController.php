<?php

namespace App\Controller;

use App\Entity\Qg;
use App\Form\QgType;
use App\Repository\QgRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/qg')]
class AdminQgController extends AbstractController
{
    #[Route('/', name: 'app_admin_qg_index', methods: ['GET'])]
    public function index(QgRepository $qgRepository): Response
    {
        return $this->render('admin_qg/index.html.twig', [
            'qgs' => $qgRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_qg_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QgRepository $qgRepository): Response
    {
        $qg = new Qg();
        $form = $this->createForm(QgType::class, $qg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $qgRepository->add($qg, true);
            $this->addFlash('success', 'Le QG a été crée avec succès');
            return $this->redirectToRoute('app_admin_qg_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_qg/new.html.twig', [
            'qg' => $qg,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_qg_show', methods: ['GET'])]
    public function show(Qg $qg): Response
    {
        return $this->render('admin_qg/show.html.twig', [
            'qg' => $qg,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_qg_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Qg $qg, QgRepository $qgRepository): Response
    {
        $form = $this->createForm(QgType::class, $qg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $qgRepository->add($qg, true);
            $this->addFlash('success', 'Le QG a été modifié avec succès');
            return $this->redirectToRoute('app_admin_qg_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_qg/edit.html.twig', [
            'qg' => $qg,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_qg_delete', methods: ['POST'])]
    public function delete(Request $request, Qg $qg, QgRepository $qgRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$qg->getId(), $request->request->get('_token'))) {
            $qgRepository->remove($qg, true);
            $this->addFlash('success', 'Le QG a été supprimé avec succès');
        }

        return $this->redirectToRoute('app_admin_qg_index', [], Response::HTTP_SEE_OTHER);
    }
}
