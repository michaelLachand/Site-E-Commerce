<?php


namespace App\Controller\Purchase;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PurchasesListController extends AbstractController
{
    /**
     * @Route("/purchases", name="purchase_index")
     * @IsGranted("ROLE_USER", message="Vous devez être connecté pour accéder à vos commandes")
     */
    public function index()
    {
        //1. Nous devons nous assurer que la personne est connectée
        // (sinon redirection vers la page d'accueil) -> Security
        /** @var User $user */
        $user = $this->getUser();
        //2. Nous voulons savoir qui est connecté -> Security

        //3. Nous voulons passer l'uilisateur connecté a Tiwg afin d'afficher ses commandes
        return $this->render('purchase/index.html.twig',[
            'purchases' => $user->getPurchases()
        ]);
    }


}