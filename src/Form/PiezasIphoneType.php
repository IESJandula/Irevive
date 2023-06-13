<?php

namespace App\Form;

use App\Entity\PiezasIphone;
use App\Entity\ModelosIphone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class PiezasIphoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pieza')
            ->add('precio')
            ->add('cantidad')
            ->add('modelo_id', EntityType::class, [
                "class" => ModelosIphone::class,
                "choice_label" => "modelo",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PiezasIphone::class,
        ]);
    }
}
