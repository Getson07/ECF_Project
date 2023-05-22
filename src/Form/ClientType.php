<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends UserType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('guests', NumberType::class, [
                'attr' => ['placeholder' => 'Préciser le nombre d\'invités par défaut'],
                'required' => false,
            ])
            ->add('allergies', TextareaType::class, ['required' => false])
        ;
        $builder->get('allergies')
            ->addModelTransformer(new CallbackTransformer(
                function ($allergiesAsArray) {
                    // #dd($allergiesAsArray);
                    return count($allergiesAsArray) ? $allergiesAsArray[0]: null;
                },
                function ($allergiesAsString) {
                    return [$allergiesAsString];
                }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
