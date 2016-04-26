<?php

namespace NoticeBoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoticeType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text', array('label' => 'Tytuł:'))
            ->add('description', 'textarea', array('label' => 'Treść:'))
            ->add('expirationDate', 'datetime', array('label' => 'Data wygaśnięcia:'))
            ->add('categories', 'entity', array(
                'class' => 'NoticeBoardBundle:Category',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Kategorie:',
            ));
        if (is_null($options['data']->getPicture())) {
            $builder->add('picture', 'file', ['required' => false, 'label' => 'Zdjęcie:', 'mapped' => false]);
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'NoticeBoardBundle\Entity\Notice'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'noticeboardbundle_notice';
    }
}
