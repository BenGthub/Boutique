<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email')
                ->add('plainPassword', PasswordType::class, [
                    // instead of being set onto the object directly,
                    // this is read and encoded in the controller
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez saisir un mot de passe:',
                                ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Le mots de passe doit contenir au moins {{ limit }} charactèrs',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                                ]),
                    ],
                    'label' => "Mot de passe",
                    'help' => "doit contenir au moin 5 caracteres"
                ])
                ->add('pseudo', TextType::class, ["label" => "Pseudo"])
                ->add('nom', TextType::class, ["label" => "Nom"])
                ->add('civilite', ChoiceType::class, ["label" => "Civilité",
                    "choices" => ["M." => "h", "Mme" => "f", "Mixte" => 'm']])
                ->add('ville')
                ->add('code_postal', textType::class, ["label" => "Code Postal",
                    "constraints" => [new Length([
                            "min" => 5, "max" => 5,
                            "exactMessage" => "le code postal doit comporter 5 chiffres exactement"
                                ]),
                        new Regex(["pattern" => "/[0-9]{5}/",
                            "message" => "le code postal ne doit etre composé que de chiffre"])
            ]])
                ->add('adresse', TextareaType::class)
                ->add('Prenom', TextType::class, ["label" => "Prénom"])
                ->add('agreeTerms', CheckboxType::class, [
                    'mapped' => false,
                    'constraints' => [
                        new IsTrue([
                            'message' => 'Vous devez valider les C.G.U.',
                                ]),
                    ],
                    'label' => "j'accepte les condition d'utilisation générales"
                ])
                ->add('Eregistrer', SubmitType::class,["attr"=>["class"=> "btn btn-primary"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }

}
