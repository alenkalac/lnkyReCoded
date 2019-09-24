<?php
namespace App\Controller;

use App\Lnky\AdflyApi;
use App\Lnky\UrlManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/short/{url}")
     * @param Request $request
     * @param UrlManager $urlManager
     * @return Response
     */
    public function genUrl(Request $request, UrlManager $urlManager) {
        $url = $request->get("url");
        //TODO: VALIDATE URL

        $link = $urlManager->generateAndLink($url);

        return new Response($link->getShort());
    }

    /**
     * @Route("/{short}")
     * @param Request $request
     * @param AdflyApi $adflyApi
     * @return Response
     */
    public function shortCode(Request $request, AdflyApi $adflyApi) {
        $short = $request->get("short");

        $userId = $_ENV["ADFLY_USER_ID"];
        $pub = "ADFLY_PUBLIC_KEY";
        $adflyApi->setUserId($userId);
        $adflyApi->setPublicKey($pub);

        //$short = $adflyApi->shorten(array('https://pickawinner.co/1234'), null, null, "474175");

        //return new Response($short->getBody()->getContents());
        return new Response($short);
    }

}