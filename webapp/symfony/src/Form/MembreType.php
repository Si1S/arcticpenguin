<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
//use Symfony\Component\Validator\Constraints\NotBlank;
//use Symfony\Component\Validator\Constraints\Length;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('telephone')
            ->add('username')
            ->add('password', PasswordType::class, [
                'mapped' => false
                //'constraints' => [
                  //  new NotBlank(['message' => 'Le mot de passe est obligatoire.']),
                    //new Length([
                      //  'min' => 6,
                        //'minMessage' => 'Le mot de passe doit faire au moins {{ limit }} caractères.',
                    //]),
                ],
            )
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
