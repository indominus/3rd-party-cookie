<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{

    const COOKIE_NAME = '_3rd_party_cookie_';

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param SessionInterface $session
     * @return JsonResponse
     */
    public function index(Request $request, SessionInterface $session): JsonResponse
    {

        $session->set(self::COOKIE_NAME, true);

        $token = bin2hex(openssl_random_pseudo_bytes(32));

        return new JsonResponse(['token' => $token]);
    }

    /**
     * @Route("/form", methods={"GET", "POST"})
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    public function form(Request $request, SessionInterface $session): Response
    {

        if (null === $session->get(self::COOKIE_NAME, null)) {
            return new Response('Missing required parameters.');
        }

        $form = $this->createFormBuilder()->add('pan', TextType::class, [
            'label' => 'PAN'
        ])->getForm();

        return $this->render('homepage/index.html.twig', [
            'form' => $form->createView(),
            'session' => $session->get(self::COOKIE_NAME, null)
        ]);
    }
}
