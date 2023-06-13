<?php

namespace App\Controller;

use App\Entity\Reparaciones;
use App\Form\ReparacionesType;
use App\Repository\ReparacionesRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

#[Route('/reparaciones')]
class ReparacionesController extends AbstractController
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    #[Route('/', name: 'app_reparaciones_index', methods: ['GET'])]
    public function index(ReparacionesRepository $reparacionesRepository): Response
    {
        return $this->render('reparaciones/index.html.twig', [
            'reparaciones' => $reparacionesRepository->findAll(),
        ]);
    }

   #[Route('/new', name: 'app_reparaciones_new', methods: ['GET', 'POST'])]
public function new(Request $request, ReparacionesRepository $reparacionesRepository): Response
{
    $reparacione = new Reparaciones();
    $form = $this->createForm(ReparacionesType::class, $reparacione);
    $form->handleRequest($request);

    try {
        if ($form->isSubmitted() && $form->isValid()) {
            $reparacionesRepository->save($reparacione, true);
            $this->addFlash('success', '¡Peticion Realizada!');
            return $this->redirectToRoute('app_reparaciones_index', [], Response::HTTP_SEE_OTHER);
        }
    } catch (\RuntimeException $e) {
    $loginUrl = $this->urlGenerator->generate('app_login');
    return new RedirectResponse($loginUrl);
    }
    

    return $this->renderForm('reparaciones/new.html.twig', [
        'reparacione' => $reparacione,
        'form' => $form,
    ]);
}


    #[Route('/{id}', name: 'app_reparaciones_show', methods: ['GET'])]
    public function show(Reparaciones $reparacione): Response
    {
        return $this->render('reparaciones/show.html.twig', [
            'reparacione' => $reparacione,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reparaciones_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reparaciones $reparacione, ReparacionesRepository $reparacionesRepository): Response
    {
        $form = $this->createForm(ReparacionesType::class, $reparacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reparacionesRepository->save($reparacione, true);

            return $this->redirectToRoute('app_reparaciones_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reparaciones/edit.html.twig', [
            'reparacione' => $reparacione,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reparaciones_delete', methods: ['POST'])]
    public function delete(Request $request, Reparaciones $reparacione, ReparacionesRepository $reparacionesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reparacione->getId(), $request->request->get('_token'))) {
            $reparacionesRepository->remove($reparacione, true);
        }

        return $this->redirectToRoute('app_reparaciones_index', [], Response::HTTP_SEE_OTHER);
    }
}
