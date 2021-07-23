<?php

namespace App\Controller\Purchase;

use DateTime;
use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use Doctrine\ORM\EntityManager;
use PhpParser\Node\Stmt\Return_;
use App\Purchase\PurchasePersiter;
use App\Form\CarteConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class PurchasesConfirmationController extends AbstractController
{

    protected $router;
    protected $cartService;
    protected $em;
    protected $persister;



    public function __construct(RouterInterface $router,  CartService $cartService, EntityManagerInterface $em, PurchasePersiter $persister)
    {

        $this->router = $router;
        $this->cartService = $cartService;
        $this->em = $em;
        $this->persister = $persister;
    }




    /**
     * @Route("/purchases/confirm", name="purchases_confirm")
     * @IsGranted("ROLE_USER",message="vous devez etre connecte  pour confirmer une commande")
     */
    public function  confirm(Request $request)
    {
        $form = $this->createForm(CarteConfirmationType::class);


        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            $this->addFlash('warning', 'vous devez remplir le formulaire de confirmation');
            return $this->redirectToRoute('carte_show');
        }
        $cartItems = $this->cartService->getDetailed();

        if (count($cartItems) === 0) {
            $this->addFlash('warning', 'vous ne pouver confirmer une commande avec pannier est vide');
            return $this->redirectToRoute('carte_show');
        }
        /**
         *  @var Purchase  */
        $purchase = $form->getData();

        $this->persister->storePurchase($purchase);


        return $this->redirectToRoute('purchase_payment_form',[
            'id'=>$purchase->getId()
        ]);
    }
}
