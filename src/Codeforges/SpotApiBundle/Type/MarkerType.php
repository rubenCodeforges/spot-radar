<?php
namespace Codeforges\SpotApiBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MarkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'text');
        $builder->add('description', 'textarea');
        $builder->add('location', 'text');
        $builder->add('user', 'document', [
            'class' => 'Codeforges\CFRest\ApiBundle\Document\User'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Codeforges\SpotApiBundle\Document\Marker',
        ));
    }

    public function getName()
    {
        return 'marker';
    }
}