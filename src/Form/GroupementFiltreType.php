<?php

namespace App\Form;

use App\Dto\GroupementFiltreDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire de filtre : envoye en GET pour que le filtre reste dans l'URL
 * (et se conserve quand on change de page).
 */
final class GroupementFiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'required' => false,
            ])
            ->add('filtrer', SubmitType::class, ['label' => 'Filtrer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GroupementFiltreDto::class,
            'method' => 'GET',
            'csrf_protection' => false,
            // le parametre "page" arrive dans l'URL sans etre un champ du formulaire
            'allow_extra_fields' => true,
        ]);
    }

    public function getBlockPrefix(): string
    {
        // parametres propres dans l'URL : ?telephone=77&ville=Dakar&page=2
        return '';
    }
}