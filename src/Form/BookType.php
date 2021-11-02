<?php

namespace App\Form;

use App\Entity\Books;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ["attr" => ["placeholder" => "Title"]])
            ->add('author', TextType::class, ["attr" => ["placeholder" => "Author"]])
            ->add('image', UrlType::class, ["attr" => ["placeholder" => "Image URL"]])
            ->add('genre', TextType::class, ["attr" => ["placeholder" => "Genre"]])
            ->add('description', TextareaType::class, ["attr" => ["placeholder" => "Description"]])
            ->add('numberOfPages', NumberType::class, ["attr" => ["placeholder" => "Number Of Pages"]])
            ->add('price', NumberType::class, ["attr" => ["placeholder" => "Price"]])
            ->add('submit', SubmitType::class, ['label' => 'Add Book']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
