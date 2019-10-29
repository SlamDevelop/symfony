<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FormAddNews extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Загаловок'])
			->add('desc', TextareaType::class, ['label' => 'Описание'])
			->add('category', ChoiceType::class, array(
				'choices'  => array(
					'Политика' => 'policy',
					'Технологии' => 'technologies',
					'Погода' => 'weather',
					'Экономика' => 'economy',
					'Происшествия' => 'incidents',
				),
				'label' => 'Категория',
			))
			->add('image', FileType::class, ['label' => 'Картинка', 'required' => false])
            ->add('save', SubmitType::class, array('label' => 'Создать новость'));
    }
}