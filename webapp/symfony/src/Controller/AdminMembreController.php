<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;

#[Route('/admin/membre', name: 'app_admin_membre_')]
#[IsGranted('ROLE_ADMIN')]
class AdminMembreController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        MembreRepository $membreRepository,
        EntityManagerInterface $em
    ): Response {
        $membres = $membreRepository->findAll();

        $id = $request->query->get('id');
        $membre = null;
        $form = null;

        if ($id) {
            $membre = $membreRepository->find($id);

            if ($membre) {
                $form = $this->createFormBuilder($membre)
                    ->add('roles', ChoiceType::class, [
                        'choices'  => [
                            'Utilisateur' => 'ROLE_USER',
                            'Administrateur' => 'ROLE_ADMIN',
                            'Rédacteur' => 'ROLE_REDACTOR',
                        ],
                        'expanded' => true,
                        'multiple' => true,
                        'label'    => 'Rôles',
                    ])
                    ->add('submit', SubmitType::class, [
                        'label' => 'Enregistrer les rôles',
                        'attr'  => ['class' => 'btn btn-primary'],
                    ])
                    ->getForm();

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $em->flush();

                    $this->addFlash('success', 'Rôles du membre mis à jour.');

                    return $this->redirectToRoute('app_admin_membre_index');
                }
            }
        }

        return $this->render('admin/membre/index.html.twig', [
            'membres' => $membres,
            'form'    => $form?->createView(),
            'membreSelectionne' => $membre,
        ]);
    }
    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    #[IsCsrfTokenValid('delete_membre', tokenKey: 'token')]
    public function delete(
        Membre $membre,
        EntityManagerInterface $em
    ): Response {
        $em->remove($membre);
        $em->flush();

        $this->addFlash('success', 'Le membre a été supprimé.');

        return $this->redirectToRoute('app_admin_membre_index');
    }
}
