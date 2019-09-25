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
     * @Route("/short", name="short", methods={"POST"})
     * @param Request $request
     * @param UrlManager $urlManager
     * @param AdflyApi $adflyApi
     * @return Response
     */
    public function genUrl(Request $request, UrlManager $urlManager, AdflyApi $adflyApi) {
        $url = $request->get("url");
        //TODO: VALIDATE URL

        $userId = $_ENV["ADFLY_USER_ID"];
        $pub = $_ENV["ADFLY_PUBLIC_KEY"];
        $adflyApi->setUserId($userId);
        $adflyApi->setPublicKey($pub);

        $link = $urlManager->generateShortLink($url);
        $urlShortLink = "http://lnky.cc/" . $link->getShort();

        $remoteUrl = $adflyApi->shorten(array($urlShortLink));
        $urlManager->linkAndSave($remoteUrl);

        return new Response($remoteUrl);
    }

    /**
     * @Route("/{short}")
     * @param Request $request
     * @return Response
     */
    public function shortCode(Request $request) {
        $short = $request->get("short");

        $userId = $_ENV["ADFLY_USER_ID"];
        $pub = $_ENV["ADFLY_PUBLIC_KEY"];
        $adflyApi->setUserId($userId);
        $adflyApi->setPublicKey($pub);

        //$short = $adflyApi->shorten(array('https://pickawinner.co/1234'), null, null, "474175");

        //return new Response($short->getBody()->getContents());
        return new Response($short);
    }

}