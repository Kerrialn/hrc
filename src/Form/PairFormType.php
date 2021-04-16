<?php

namespace App\Form;

use App\Entity\Pair;
use App\Entity\Resume;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class PairFormType extends AbstractType
{

    public function __construct(
        private Security $security
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();

        $builder
            ->add('resume', EntityType::class, [
                'label' => false,
                'class' => Resume::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('r')
                        ->where('r.owner = :user')
                        ->setParameter('user', $user)
                        ->orderBy('r.createdAt', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('likeBtn', SubmitType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'bg-success text-white bi bi-heart-fill form-icon-btn'
                ]
            ])
            ->add('nextBtn', SubmitType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'bg-danger text-white bi bi-x form-icon-btn'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pair::class,
        ]);
    }
}
