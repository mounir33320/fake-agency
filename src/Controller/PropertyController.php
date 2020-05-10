<?php
namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController{

    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(PropertyRepository $repository,EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/biens", name="property.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param $slug
     * @return Response
     */
    public function index(PaginatorInterface $paginator,Request $request):Response{

        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        $propertiesQuery = $this->repository->findAllUnsolved($search);
        $properties = $paginator->paginate(
            $propertiesQuery,
            $request->query->getInt("pouge",1),
            12
        );

        return $this->render("property/index.html.twig",[
            "current_page" => "properties",
            "properties" => $properties,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9-]*"})
     * @param Property $property
     * @param Request $request
     * @param $slug
     * @param ContactNotification $notification
     * @return Response
     */
    public function show(Property $property, Request $request, $slug,ContactNotification $notification){
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute("property.show",[
                "id" => $property->getId(),
                "slug" => $property->getSlug()
            ],301);
        }

        $contact = new Contact();
        $contact->setProperty($property);
        $formContact = $this->createForm(ContactType::class,$contact);

        $formContact->handleRequest($request);
        if($formContact->isSubmitted() && $formContact->isValid()){
            $notification->notify($contact);
            $this->addFlash("success", "Votre message a été envoyé avec succès !");

            return $this->redirectToRoute("property.show",[
                "id" => $property->getId(),
                "slug" => $property->getSlug()
            ]);

        }

        return $this->render("property/show.html.twig",[
            "property"     => $property,
            "current_page" => "properties",
            "form"         => $formContact->createView()
        ]);
    }
}