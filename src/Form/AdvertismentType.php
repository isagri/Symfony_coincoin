<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 20/07/2018
 * Time: 13:26
 */

namespace App\Form;


use App\Entity\Advertisment;
use App\Entity\Category;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertismentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title",TextType::class)
            ->add("description",TextType::class)
            ->add("creationDate",DateType::class, array('disabled' => true))
            ->add("price",NumberType::class, array('label' => 'Price (euros)', 'scale' => 2))
            ->add('region',EntityType::class, array(
                'class' => Region::class,
                'choice_label' => 'name',
                'required' => false,
            ))
            ->add('category',EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false,
            ))
            ->add('uploadPhoto',FileType::class,
                array('data_class' => null, 'label' => 'Set the Photo', 'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Advertisment::class,
            ));
    }
}