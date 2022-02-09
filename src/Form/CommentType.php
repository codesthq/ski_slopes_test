<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class CommentType extends AbstractType
{
    protected $recaptchaSitekey;

    public function __construct(string $recaptchaSitekey)
    {
        $this->recaptchaSitekey = $recaptchaSitekey;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class)
            ->add('content', TextType::class)
            ->add('save', ButtonType::class, [
                'attr' => [
                    'class' => 'g-recaptcha',
                    'data-sitekey' => $this->recaptchaSitekey,
                    'data-callback' => 'onSubmit',
                    'data-action' => 'submit'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
