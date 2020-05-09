<?php
namespace App\Controller;


use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
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
     * @return Response
     */
    public function show(Property $property){
        return $this->render("property/show.html.twig",[
            "property" => $property
        ]);
    }
}