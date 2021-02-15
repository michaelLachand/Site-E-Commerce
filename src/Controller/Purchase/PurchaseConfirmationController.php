<?php


namespace App\Controller\Purchase;


use App\Cart\CartService;
use App\Entity\Purchase;
use App\Form\CartConfirmationType;
use App\Purchase\PurchasePersister;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseConfirmationController extends AbstractController
{
    protected $cartService;
    protected $em;
    protected $persister;

    /**
     * PurchaseConfirmationController constructor.
     * @param CartService $cartService
     * @param EntityManagerInterface $em
     * @param PurchasePersister $persister
     */
    public function __construct(CartService $cartService, EntityManagerInterface $em, PurchasePersister $persister)
    {
        $this->cartService = $cartService;
        $this->em = $em;
        $this->persister = $persister;
    }

    /**
     * @Route("/purchase/confirm", name="purchase_confirm")
     * @IsGranted("ROLE_USER", message="Vous devez etre connecté pour confirmer une commande")
     * @param Request $request
     * @return RedirectResponse
     */
    public function confirm(Request $request)
    {
        //1. Lire les données du formulaire
        $form = $this->createForm(CartConfirmationType::class);

        $form->handleRequest($request);
        //2.Si le formulaire n'a pas été soumis : dégager
        if(!$form->isSubmitted()){
            $this->addFlash('warning', 'Vous devez remplir le formulaire de confirmation');
            return $this->redirectToRoute('cart_show');
        }

        //4. Si il n'y a pas de produits dans mon panier: dégader(CartService)
        $cartItems = $this->cartService->getDetailedCartItems();

        if(count($cartItems) === 0){
            $this->addFlash('warning', 'Vous ne pouvez configurer une commande avec un panier vide');
            return $this->redirectToRoute('cart_show');
        }

        //5. Nous allons créer une purchase
        /** @var Purchase */
        $purchase = $form->getData();

        $this->persister->storePurchase($purchase);



        return $this->redirectToRoute('purchase_payment_form',[
            'id' => $purchase->getId()
        ]);
    }

}