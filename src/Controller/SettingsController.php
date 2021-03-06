<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

use App\Form\SettingsFormType;
use App\Form\MenuFormType;
use App\Form\CategoryForm;
use App\Entity\Settings;

use App\Service\SettingService;

class SettingsController extends AbstractController
{
    /**
     * @Route("/admin/settings", name="settings")
     */
    public function index(Request $request, SettingService $s)
    {

        $em = $this->getDoctrine()->getManager();

        // Get Settings
        $setting = $em->getRepository(Settings::class)->find(1);

        $filename = 'LOGO.png';

        if ($setting->getLogo()) {
            $setting->setLogo(
                null
            );
        }

        $form = $this->createForm(SettingsFormType::class, $setting);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if ($data->getLogo()) {
                $file = $form->get('logo')->getData();

                $file->move(
                    $this->getParameter('cover_folder'),
                    $filename
                );

                $setting->setLogo($filename);
            }

            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('settings/index.html.twig', [
            'current' => 'settings',
            'headline' => 'Settings',
            'base' => $s->get(),
            'form' => $form->createView()
        ]);
    }
}
