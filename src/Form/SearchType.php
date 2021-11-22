<?php

namespace App\Form;

use App\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minPrice', IntegerType::class, ["attr" => ["placeholder" => "Min. Price"], "required" => false, "label" => false])
            ->add('maxPrice', IntegerType::class, ["attr" => ["placeholder" => "Max. Price"], "required" => false, "label" => false])
            ->add('title', TextType::class, ["attr" => ["placeholder" => "Book Title"], "required" => false, "label" => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
