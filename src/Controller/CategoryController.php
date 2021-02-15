<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends AbstractController
{

    protected $categoryRepository;

    /**
     * CategoryController constructor.
     * @param $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    public function renderMenuList()
    { // Aller chercher les catégories dans la base de données.
        $categories = $this->categoryRepository->findAll();
      // Renvoyer le rendu HTML sous la forme d'une Response
        return $this->render('category/_menu.html.twig',[
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/admin/category/{id}/edit" , name="category")
     */
    public function edit($id,CategoryRepository $categoryRepository, Request $request , EntityManagerInterface $em)

    {
        $category = $categoryRepository->find($id);

        if(!$category) {
            throw new NotFoundHttpException("Cette catégorie n'exsite pas");
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->flush();

            return $this->redirectToRoute('homepage');

        }

        $formView = $form->createView();



        return $this->render('category/edit.html.twig',[
            'category' => $category,
            'formView' => $formView,
        ]);
    }

    /**
     * @Route("/admin/category/create" , name="category_create")
     */
    public function create(Request $request, EntityManagerInterface $em,SluggerInterface $slugger)
    {
        $category = new Category;

        $form = $this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $category->setSlug(strtolower($slugger->slug($category->getName())));

            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        $formView = $form->createView();

        return $this->render('category/create.html.twig',[
            'formView' => $formView,
        ]);
    }
}
