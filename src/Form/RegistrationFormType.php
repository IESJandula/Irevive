<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'row_attr' => [
                    'class' => 'form-group'
                ]
            ])
            ->add('nombre', null, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-z]+$/',
                        'message' => 'Los Nombre solo pueden contener letras.',
                    ]),
                ],
            ])
            ->add('apellidos', null, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-z]+\s[A-Za-z]+$/',
                        'message' => 'Los apellidos solo pueden contener letras.',
                    ]),
                ],
            ])
            ->add('telefono', null, [
                'constraints' => [
                    new Length([
                        'min' => 9,
                        'max' => 9,
                        'exactMessage' => 'El número de teléfono debe tener exactamente {{ limit }} dígitos.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Porfavor introduzca la contraseña',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Tu contraseña debe tener minimo {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
