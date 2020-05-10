<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add("options",EntityType::class, [
                "class" => Option::class,
                "choice_label" => "name",
                "multiple" => true,
                "expanded" => true,
                "required" => false
            ])
            ->add("imageFile",FileType::class, [
                "required" => false
            ])
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
