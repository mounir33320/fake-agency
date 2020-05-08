<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('surface')
            ->add('price')
            ->add('rooms')
            ->add('bedrooms')
            ->add('heat', ChoiceType::class, [
                "choices" => $this->getChoices(),
                "expanded" => true
            ])
            ->add('floor')
            ->add('adress')
            ->add('city')
            ->add('postal_code')
            ->add('sold')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            "translation_domain" => "form"
        ]);
    }

    private function getChoices(){
        $heats = Property::HEAT;
        $output = [];
        foreach($heats as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }
}
