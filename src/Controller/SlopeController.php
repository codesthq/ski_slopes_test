<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Slope;
use App\Form\CommentType;
use App\Form\SlopeSearchType;
use App\Form\SlopeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\SlopeRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;

class SlopeController extends AbstractController
{
    #[Route('/', name: 'slope-index')]
    public function index(Request $request, SlopeRepository $slopeRepository): Response
    {
        $form = $this->createForm(SlopeSearchType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && !empty($phrase = $form->getData()['phrase']))
        {
            $slopes = $slopeRepository->findByNameOrCity($phrase);
        }
        else
        {
            $slopes = $slopeRepository->findAll();
        }
        foreach ($slopes as $slope)
        {
            $slope->detailsUrl = $this->generateUrl('slope-show', ['id' => $slope->getId()]);
        }

        return $this->renderForm('slope/index.html.twig', ['slopes' => $slopes, 'form' => $form]);
    }

    #[Route('/{id}', name: 'slope-show', priority: -1)]
    public function show(int $id, Request $request, SlopeRepository $slopeRepository, ManagerRegistry $doctrine): Response
    {
        $slope = $slopeRepository->find($id);
        $comments = $slope->getComments();

        $comment = new Comment();
        $comment->setCreatedAt(new DateTimeImmutable());
        $comment->setIpAddress($request->getClientIp());
        $comment->setSlope($slope);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $comment = $form->getData();
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('slope-show', ['id' => $id]);
        }
        
        return $this->renderForm('slope/details.html.twig', ['form' => $form, 'slope' => $slope, 'comments' => $comments]);
    }
}
