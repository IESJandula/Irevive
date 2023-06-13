<?php

namespace App\Form;

use App\Entity\Reparaciones;
use App\Entity\PiezasIphone;
use App\Entity\Usuario;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ReparacionesType extends AbstractType
{
    private $security;
    private $urlGenerator;

    public function __construct(Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        if ($user === null) {
            throw new \RuntimeException('Usuario no autenticado');
        }

        $builder
            ->add('descripcion')
            ->add('fecha')
            ->add('usuario_id', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => function ($usuario) {
                    return $usuario->getEmail();
                },
                'choice_value' => 'id',
                "data" => $user,
            ])
            ->add('pieza_id', EntityType::class, [
                "class" => PiezasIphone::class,
                "choice_label" => function (PiezasIphone $pieza) {
                    return $pieza->getPieza() . ' ' . $pieza->getModeloId()->getModelo() . ' ' . $pieza->getPrecio() . '€';
                },
                "choice_attr" => function (PiezasIphone $pieza) {
                    strtolower(str_replace(' ', '_', $pieza->getModeloId()->getModelo()));
                    return ['data-modelo' => str_replace(' ', '_', $pieza->getModeloId()->getModelo()),
                        'dataPrecio' => $pieza->getPrecio() . ''];
                },
                "expanded" => true, // opción para mostrar casillas de verificación
                "multiple" => true
            ]);
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                $user = $this->security->getUser();
    
                if ($user === null) {
                    throw new \RuntimeException('Usuario no autenticado');
                }
    
                // Establecer el usuario actual como el valor del campo usuario_id
                $form->get('usuario_id')->setData($user);
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reparaciones::class,
        ]);
    }
}
