<?php
namespace Codeforges\SpotRadar\SpotApiBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
        $builder->add('password', 'repeated', array(
            'first_name' => 'password',
            'second_name' => 'confirm',
            'type' => 'password'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Codeforges\SpotRadar\SpotApiBundle\Model\User',
        ));
    }

    public function getName()
    {
        return 'user';
    }
}