<?php

namespace Massimo\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('auteur')
            ->add('title')
            ->add('contenu')
            ->add('datecreation', 'date', array('widget' =>'single_text'))
            ->add('publication', 'checkbox', array("required"=>false))
        
        	->add('categories', 'entity', array ("class"=>"MassimoBlogBundle:Categorie", "property"=>"nom", "multiple"=>true, "expanded"=>true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Massimo\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'massimo_blogbundle_article';
    }
}
