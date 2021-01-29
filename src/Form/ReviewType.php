<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Review;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('title')
            ->add('content')
            ->add('create_at')
            ->add('update_at')
            ->add('is_publised')
            ->add('product')*/

            ->add('title', TextType::class, array(
                'label' => 'Заголовок отзыва',
                'attr' => [
                    'placeholder' => 'Введите текст'
                ]
            ))
            ->add('product', EntityType::class, array(
                'label' => 'Продукт',
                'class' => Product::class,
                'choice_label' => 'name' //'choice_label' => 'title' ? 'name'
            ))
            ->add('content', TextType::class, array(
                'label' => 'Отзыв', //'Заголовок категории'
                'attr' => [
                    'placeholder' => 'Введите текст'
                ]
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-success float-left mr-2'
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
            'data_class' => Review::class,
        ]);
    }
}
