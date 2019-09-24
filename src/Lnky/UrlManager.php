<?php
namespace App\Lnky;

use App\Entity\Links;
use Doctrine\ORM\EntityManagerInterface;

class UrlManager {
    private $generator;
    private $entityManager;

    public function __construct(UrlGenerator $generator, EntityManagerInterface $entityManager) {
        $this->generator = $generator;
        $this->entityManager = $entityManager;
    }

    public function generateAndLink($url): Links {
        $short = $this->generator->getRandomShortUrl(6);
        $link = new Links();
        $link->setUrl($url);
        $link->setShort($short);

        $this->entityManager->persist($link);
        $this->entityManager->flush();

        return $link;
    }
}