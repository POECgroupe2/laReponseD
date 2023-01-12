<?php

namespace App\Controller\Back;

use App\Entity\Level;
use App\Form\LevelType;
use App\Repository\LevelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
#[Route('/back/level')]
class LevelController extends AbstractController
{
    #[Route('/', name: 'app_back_level_index', methods: ['GET'])]
    public function index(LevelRepository $levelRepository): Response
    {
        return $this->render('back/level/index.html.twig', [
            'levels' => $levelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_level_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LevelRepository $levelRepository): Response
    {
        $level = new Level();
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $levelRepository->save($level, true);

            return $this->redirectToRoute('app_back_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/level/new.html.twig', [
            'level' => $level,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_level_show', methods: ['GET'])]
    public function show(Level $level): Response
    {
        return $this->render('back/level/show.html.twig', [
            'level' => $level,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_level_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Level $level, LevelRepository $levelRepository): Response
    {
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $levelRepository->save($level, true);

            return $this->redirectToRoute('app_back_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/level/edit.html.twig', [
            'level' => $level,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_level_delete', methods: ['POST'])]
    public function delete(Request $request, Level $level, LevelRepository $levelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$level->getId(), $request->request->get('_token'))) {
            $levelRepository->remove($level, true);
        }

        return $this->redirectToRoute('app_back_level_index', [], Response::HTTP_SEE_OTHER);
    }
}
