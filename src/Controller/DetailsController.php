<?php

namespace App\Controller;

use App\Entity\Details;
use App\Form\DetailsType;
use App\Repository\DetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/details")
 */
class DetailsController extends AbstractController
{
    /**
     * @Route("/", name="details_index", methods={"GET"})
     */
    public function index(DetailsRepository $detailsRepository): Response
    {
        return $this->render('details/index.html.twig', [
            'details' => $detailsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="details_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detail = new Details();
        $form = $this->createForm(DetailsType::class, $detail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detail);
            $entityManager->flush();

            return $this->redirectToRoute('details_index');
        }

        return $this->render('details/new.html.twig', [
            'detail' => $detail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="details_show", methods={"GET"})
     */
    public function show(Details $detail): Response
    {
        return $this->render('details/show.html.twig', [
            'detail' => $detail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="details_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Details $detail): Response
    {
        $form = $this->createForm(DetailsType::class, $detail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('details_index');
        }

        return $this->render('details/edit.html.twig', [
            'detail' => $detail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="details_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Details $detail): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('details_index');
    }
}
