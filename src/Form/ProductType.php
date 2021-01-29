<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /*public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('image')
            ->add('create_at')
            ->add('description')
            ->add('category')
        ;
    }
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, array(
                'label' => 'Главное изображение',
                'required' => false,
                'mapped' => false,
            ))
            ->add('category', EntityType::class, array(
                'label' => 'Категории',
                'class' => Category::class,
                'choice_label' => 'title' //'choice_label' => 'title' ? 'name'
            ))
            ->add('name', TextType::class, array(
                'label' => 'Заголовок товара', //'Заголовок категории'
                'attr' => [
                    'placeholder' => 'Введите текст'
                ]
            ))
            /*->add('content', TextareaType::class, array(
                'label' => 'Описание категории',
                'attr' => [
                    'placeholder' => 'Введите описание'
                ]
            ))*/
            ->add('save', SubmitType::class, array(
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-success float-left mr-3'
                ]
            ))
            ->add('delete', SubmitType::class, array(
                'label' => 'Удалить',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
