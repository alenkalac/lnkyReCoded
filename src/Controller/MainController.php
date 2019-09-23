<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    /**
     * @Route("/")
     */
    public function home() {
        return $this->render("index.twig", []);
    }

    /**
     * @Route("/login")
     */
    public function login() {
        return $this->render("login.twig", []);
    }

}