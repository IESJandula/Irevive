<?php

namespace App\Controller;

use App\Entity\PiezasIphone;
use App\Form\PiezasIphoneType;
use App\Repository\PiezasIphoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Route('/piezas/iphone')]
#[Security("is_granted('ROLE_ADMIN')")]
class PiezasIphoneController extends AbstractController
{
    #[Route('/', name: 'app_piezas_iphone_index', methods: ['GET'])]
    public function index(PiezasIphoneRepository $piezasIphoneRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('access_denied');
        }

        return $this->render('piezas_iphone/index.html.twig', [
            'piezas_iphones' => $piezasIphoneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_piezas_iphone_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PiezasIphoneRepository $piezasIphoneRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('access_denied');
        }

        $piezasIphone = new PiezasIphone();
        $form = $this->createForm(PiezasIphoneType::class, $piezasIphone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $piezasIphoneRepository->save($piezasIphone, true);

            return $this->redirectToRoute('app_piezas_iphone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('piezas_iphone/new.html.twig', [
            'piezas_iphone' => $piezasIphone,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_piezas_iphone_show', methods: ['GET'])]
    public function show(PiezasIphone $piezasIphone): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('access_denied');
        }
        return $this->render('piezas_iphone/show.html.twig', [
            'piezas_iphone' => $piezasIphone,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_piezas_iphone_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PiezasIphone $piezasIphone, PiezasIphoneRepository $piezasIphoneRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('access_denied');
        }
        $form = $this->createForm(PiezasIphoneType::class, $piezasIphone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $piezasIphoneRepository->save($piezasIphone, true);

            return $this->redirectToRoute('app_piezas_iphone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('piezas_iphone/edit.html.twig', [
            'piezas_iphone' => $piezasIphone,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_piezas_iphone_delete', methods: ['POST'])]
    public function delete(Request $request, PiezasIphone $piezasIphone, PiezasIphoneRepository $piezasIphoneRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('access_denied');
        }
        
        if ($this->isCsrfTokenValid('delete'.$piezasIphone->getId(), $request->request->get('_token'))) {
            $piezasIphoneRepository->remove($piezasIphone, true);
        }

        return $this->redirectToRoute('app_piezas_iphone_index', [], Response::HTTP_SEE_OTHER);
    }
}
