<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['required' => true])
            ->add('password', PasswordType::class, ['required' => true])
            ->add('confirmPassword', PasswordType::class, ['required' => true, 'mapped' => false])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'H',
                    'Femme' => 'F',
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('firstname', TextType::class, ['required' => true])
            ->add('dateOfBirth', DateType::class, ['widget' => 'single_text',
            'attr' => ['class' => 'js-datepicker'],])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMINISTRATOR',
                    'CLient' => 'ROLE_CLIENT',
                ],
                'multiple' => false,
                'expanded' => true,
            ])
        ;
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesAsArray) {
                    // #dd($rolesAsArray);
                    // return count($rolesAsArray) ? $rolesAsArray[0]: null;
                },
                function ($rolesAsString) {
                    return [$rolesAsString];
                }
        ));
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
