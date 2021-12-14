<?php

namespace App\Form;

use App\Entity\Profile;
use App\Form\AvatarType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('facebookUrl', UrlType::class, ["required" => false])
            ->add('twitterUrl', UrlType::class, ["required" => false])
            ->add('instagramUrl', UrlType::class, ["required" => false])
            ->add('fullName', TextType::class, ["attr" => ["placeholder" => "Full Name"], 'required'   => false])
            ->add('about', TextareaType::class, ["attr" => ["placeholder" => "About Me!", 'rows' => '3'], 'required'   => false])
            ->add('userAvatar', AvatarType::class, array('data_class' => 'App\Entity\Avatar', 'label' => false))
            ->add('submit', SubmitType::class, ['label' => 'Save Profile']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
