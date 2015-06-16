<?php

namespace Massimo\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeleteArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('article', 'entity', array ("class"=>"MassimoBlogBundle:Article", "property"=>"title", "multiple"=>false, "expanded"=>false))
        ;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'massimo_blogbundle_deletearticle';
    }
}
