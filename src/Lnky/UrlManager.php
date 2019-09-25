<?php
namespace App\Lnky;

use App\Entity\Links;
use Doctrine\ORM\EntityManagerInterface;

class UrlManager {
    private $generator;
    private $entityManager;

    /**
     * @var Links
     */
    private $link;

    public function __construct(UrlGenerator $generator, EntityManagerInterface $entityManager) {
        $this->generator = $generator;
        $this->entityManager = $entityManager;
    }

    public function generateShortLink($url): Links {
        $short = $this->generator->getRandomShortUrl(6);
        $this->link = new Links();
        $this->link->setUrl($url);
        $this->link->setShort($short);
        return $this->link;
    }

    public function linkAndSave($remoteUrl) {
        $this->link->setRemoteUrl($remoteUrl);
        $this->entityManager->persist($this->link);
        $this->entityManager->flush();
    }
}