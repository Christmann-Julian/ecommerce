<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id', 'ID'),
            DateField::new('createdAt', 'Date'),
            TextField::new('user.getFullName', 'Nom'),
            MoneyField::new('total')->setCurrency('EUR'),
            ChoiceField::new('state', 'Statut')->setChoices([
                'non payé' => 0,
                'en cours' => 1,
                'livré' => 2
            ])
        ];
    }

}
