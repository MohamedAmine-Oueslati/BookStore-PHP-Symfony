<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatar', FileType::class, ["required" => false])
            ->add('email', EmailType::class, ["attr" => ["placeholder" => "Email"]])
            ->add('username', TextType::class, ["attr" => ["placeholder" => "Username"]])
            ->add('fullName', TextType::class, ["attr" => ["placeholder" => "Full Name"], 'required'   => false])
            ->add('about', TextareaType::class, ["attr" => ["placeholder" => "About Me!", 'rows' => '3'], 'required'   => false])
            ->add('submit', SubmitType::class, ['label' => 'Save Profile']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
