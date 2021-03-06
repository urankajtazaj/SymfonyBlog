<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Service\SettingService;

use App\Form\CategoryForm;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category/add", name="category_add")
     */
    public function index(Request $request, SettingService $setting)
    {

        $category = new Category();
        $form = $this->createForm(CategoryForm::class, $category);

        $categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();

                return $this->redirectToRoute('category_add');
            }
        }

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView(),
            'headline' => 'Categories',
            'categories' => $categories,
            'current' => 'category',
            'base' => $setting->get()
        ]);
    }

    /**
     * @Route("/admin/category/edit/{id}", name="category_edit")
     */
    public function edit(Request $request, SettingService $setting, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);
        $categories = $em->getRepository(Category::class)->findAll();

        $form = $this->createForm(CategoryForm::class, $category);

        $form->handleRequest($request);
        
        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->flush();

                return $this->redirectToRoute("category_add");
            }
        }

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView(),
            'headline' => 'Edit Category',
            'categories' => $categories,
            'current' => 'category',
            'base' => $setting->get()
        ]);
    }

    /**
     * @Route("/admin/category/delete/{id}", name="category_delete")
     */
    public function delete($id) {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);
    
        $em->remove($category);
        $em->flush();

        $this->addFlash(
            'success',
            "Category has been deleted successfully."
        );

        return $this->redirectToRoute('category_add');
    
    }

}
