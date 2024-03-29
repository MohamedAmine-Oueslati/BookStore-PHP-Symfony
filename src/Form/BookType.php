<?php

namespace App\Form;

use App\Entity\BookGenre;
use App\Entity\Books;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ["attr" => ["placeholder" => "Title"]])
            ->add('author', TextType::class, ["attr" => ["placeholder" => "Author"]])
            ->add('imageFile', VichFileType::class, ["required" => true])
            ->add('genre', EntityType::class, [
                "class" => BookGenre::class,
                "multiple" => true,
                "required" => true,
            ])
            ->add('numberOfPages', NumberType::class, ["attr" => ["placeholder" => "Number Of Pages"]])
            ->add('price', NumberType::class, ["attr" => ["placeholder" => "Price"]])
            ->add('description', TextareaType::class, ["attr" => ["placeholder" => "Description", 'rows' => '3']])
            ->add('submit', SubmitType::class, ['label' => 'Add Book']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
