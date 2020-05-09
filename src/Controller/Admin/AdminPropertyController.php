<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $manager, PropertyRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(){
        return $this->render("admin/login.html.twig");
    }

    /**
     * @Route("/admin", name="admin.index")
     * @return Response
     */
    public function index():Response{
        $properties = $this->repository->findAll();
        return $this->render("admin/index.html.twig", [
            "properties" => $properties,
            "current_page" => "admin"
        ]);
    }

    /**
     * @Route("/admin/edit-{id}", name="admin.edit")
     * @param Property $property
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Property $property, Request $request,EntityManagerInterface $manager):Response{
        $form = $this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();
            $this->addFlash("success","Le bien a été modifié avec succès");
            return $this->redirectToRoute("admin.index");
        }

        return $this->render("admin/edit.html.twig", [
            "form" => $form->createView(),
            "current_page" => "admin"
        ]);
    }

    /**
     * @Route("admin/new", name="admin.new")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $manager):Response{
        $property = new Property();
        $form = $this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($property);
            $manager->flush();
            $this->addFlash("success","Le bien a été ajouté avec succès");
            return $this->redirectToRoute("admin.index");
        }
        return $this->render("admin/new.html.twig", [
            "form" => $form->createView(),
            "current_page" => "admin"
        ]);
    }

    /**
     * @Route("/admin/delete-{id}", name="property.delete", methods={"DELETE"})
     */
    public function delete(Property $property,Request $request, EntityManagerInterface $manager){
        $propertyId = $property->getId();
        $token = $request->get("_token");
        if($this->isCsrfTokenValid("delete-".$propertyId,$token)){
            $manager->remove($property);
            $manager->flush();
            $this->addFlash("success","Le bien a été supprimé avec succès");
            return $this->redirectToRoute("admin.index");
        }
    }

}