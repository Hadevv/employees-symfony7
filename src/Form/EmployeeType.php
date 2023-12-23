<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Gender;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('birthDate')
            ->add('firstName')
            ->add('lastName')
            ->add('gender', EnumType::class, ['class' => Gender::class])
            ->add('hireDate')
            ->add('photo')
            ->add('email');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
