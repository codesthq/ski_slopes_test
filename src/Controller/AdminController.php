<?php

namespace App\Controller;

use App\Entity\Slope;
use App\Repository\CommentRepository;
use App\Repository\SlopeRepository;
use App\Form\SlopeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(SlopeRepository $slopeRepository): Response
    {
        $slopes = $slopeRepository->findAll();
        foreach ($slopes as $slope) {
            $slope->editUrl = $this->generateUrl('admin-update', ['id' => $slope->getId()]);
            $slope->deleteUrl = $this->generateUrl('admin-delete', ['id' => $slope->getId()]);
            $slope->commentsUrl = $this->generateUrl('admin-comments', ['id' => $slope->getId()]);
        }

        return $this->render('admin/index.html.twig', ['slopes' => $slopes]);
    }

    #[Route('/admin/store', name: 'admin-store')]
    public function store(Request $request, ManagerRegistry $doctrine): Response
    {
        $slope = new Slope();
        $form = $this->createForm(SlopeType::class, $slope);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $slope = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($slope);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->renderForm('admin/form.html.twig', ['form' => $form]);
    }

    #[Route('/admin/update/{id}', name: 'admin-update')]
    public function update(int $id, Request $request, SlopeRepository $slopeRepository, ManagerRegistry $doctrine)
    {
        $slope = $slopeRepository->find($id);
        $form = $this->createForm(SlopeType::class, $slope);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $slope = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($slope);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->renderForm('admin/form.html.twig', ['form' => $form]);
    }

    #[Route('/admin/delete/{id}', name: 'admin-delete')]
    public function delete(int $id, ManagerRegistry $doctrine, SlopeRepository $slopeRepository)
    {
        $slope = $slopeRepository->find($id);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($slope);
        $entityManager->flush();

        return $this->redirectToRoute('admin');
    }

    #[Route('/admin/{id}/comments', name: 'admin-comments')]
    public function showComments(int $id, CommentRepository $commentRepository)
    {
        $comments = $commentRepository->findBy(['slope' => $id]);
        foreach ($comments as $comment) {
            $comment->deleteUrl = $this->generateUrl('admin-comment-delete', ['slopeId' => $id, 'commentId' => $comment->getId()]);
            $comment->createdAtReadable = $comment->getCreatedAt()->format('Y-m-d H:i:s');
        }
        
        return $this->render('admin/comments.html.twig', ['comments' => $comments]);
    }

    #[Route('/admin/{slopeId}/comments/{commentId}/delete', name: 'admin-comment-delete')]
    public function deleteComment(int $slopeId, int $commentId, ManagerRegistry $doctrine, CommentRepository $commentRepository)
    {
        $comment = $commentRepository->find($commentId);

        $entityManager = $doctrine->getManager();
        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute('admin-comments', ['id' => $slopeId]);
    }
}
