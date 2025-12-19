<?php
namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('dateCreation', DateType::class, [  // ← camelCase (propriété PHP)
                  'label' => 'Date de création',
                  'widget' => 'single_text',
		  'html5' => true,
		  'disabled' => true,
            ])
            ->add('contenu', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Article::class]);
    }
}
