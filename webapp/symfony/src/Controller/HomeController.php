<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;  // ← IMPORT CORRECT
use App\Entity\Membre;                       // ← Entité
use App\Form\MembreType;                     // ← Formulaire
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/donation', name: 'app_donation')]
    public function donation(): Response
    {
        return $this->render('donation/index.html.twig');
    }

    #[Route('/adhesion', name: 'app_adhesion')]
public function adhesion(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
{
    $membre = new Membre();
    $form = $this->createForm(MembreType::class, $membre);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // ✅ Récupération sécurisée du mot de passe
        $plainPassword = $form->get('password')->getData();
        
        // ✅ Vérifier que le mot de passe n'est pas vide
        if (null === $plainPassword || empty(trim($plainPassword))) {
            $this->addFlash('error', 'Le mot de passe est obligatoire.');
        } else {
            // ✅ Hacher le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($membre, $plainPassword);
            $membre->setPassword($hashedPassword);

            $em->persist($membre);
            $em->flush();

            $this->addFlash('success', '🎉 Bienvenue parmi nous ! Votre compte est créé.');
            return $this->redirectToRoute('app_home');
        }
    }

    return $this->render('adhesion/index.html.twig', [
        'form' => $form->createView(),
    ]);
    }
    
    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('contact/index.html.twig');
    }

    #[Route('/legal', name: 'app_legal')]
    public function legal(): Response
    {
        return $this->render('legal/index.html.twig');
    }

    #[Route('/blog', name: 'app_blog')]
    public function blog(): Response
    {
        return $this->render('blog/index.html.twig');
    }

    #[Route('/intranet', name: 'app_intranet')]
    #[IsGranted('ROLE_USER')]
    public function intranet(): Response
    {
        return $this->render('intranet/index.html.twig');
    }

    #[Route('/intranet/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function dashboard(): Response
    {
        return $this->render('intranet/dashboard.html.twig');
    }

    #[Route('/intranet/profil', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function profile(): Response
    {
    /** @var Membre|null $user */
    $user = $this->getUser();
    
    return $this->render('intranet/profile.html.twig', [
        'user' => $user,
    ]);
    }
    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/admin/article', name: 'app_admin_articles')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminArticles(): Response
    {
        return $this->render('admin/article/index.html.twig');
    }
     public function articles(EntityManagerInterface $em): Response
    {
        $articles = $em->getRepository(Article::class)->findBy([], ['dateCreation' => 'DESC']);

        return $this->render('home/article/edit.html.twig', [
            'articles' => $articles,
        ]);
    }
}
