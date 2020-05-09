<?php
namespace App\Controller;


use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController{

    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index():Response{
        $properties = $this->repository->findAllUnsolved();
        return $this->render("property/index.html.twig",[
            "current_page" => "properties",
            "properties" => $properties
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9-]*"})
     * @param Property $property
     * @return Response
     */
    public function show(Property $property){
        return $this->render("property/show.html.twig");
    }
}