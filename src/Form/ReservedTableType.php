<?php

namespace App\Form;

use App\Entity\ReservedTable;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservedTableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['mapped' => false])
            ->add('name', TextType::class, ['mapped' => false,])
            ->add('phoneNumber', TelType::class, ['mapped' => false])
            ->add('reservedForDate', DateType::class, [
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',
                'attr' => [
                    'showOnFocus' => true,
                    'class' => 'form-control input-inline js-datepicker',
                    'data-date-format' => 'dd-mm-yyyy hh:mm:ss'
                ]
            ])
            ->add('reservedTime', TimeType::class, [
                
                'mapped' => false,
                'model_timezone' => 'Europe/Paris',
            ])
            ->add('numberOfTables', NumberType::class, [
                'label' => 'Couverts',
                'attr' => [
                    'placeholder' => 'Nombre de personnes'
                ]
            ])
            ->add('hasArrived', null, [
                'required' => false,
            ])
            ->add('client')
            ->add('guestInfo')
        ;

        $builder->get('reservedForDate')
                ->addModelTransformer(new CallbackTransformer(
                    function($reservedDateImmutable){
                        #return DateTime::createFromImmutable($reservedDateImmutable);
                    },
                    function($reservedDate){
                        #dd($reservedDate);
                        $reservedDateImmutable =  DateTimeImmutable::createFromMutable($reservedDate);
                        // dd($reservedDateImmutable);
                        return $reservedDateImmutable;
                    },
                    
                ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservedTable::class,
        ]);
    }
}
