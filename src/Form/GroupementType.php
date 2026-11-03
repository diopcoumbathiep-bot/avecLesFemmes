<?php

namespace App\Form;

use App\Dto\GroupementFormDto;
use App\Enum\StatutGroupement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire lie au DTO d'entree (et non a l'entite).
 */
final class GroupementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom du groupement'])
            ->add('tel', TextType::class, ['label' => 'Téléphone'])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse (avec la ville)',
                'required' => false,
            ])
            ->add('statut', EnumType::class, [
                'label' => 'Statut',
                'class' => StatutGroupement::class,
                'choice_label' => fn (StatutGroupement $statut) => $statut->label(),
            ])
            ->add('enregistrer', SubmitType::class, ['label' => 'Enregistrer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GroupementFormDto::class,
        ]);
    }
}