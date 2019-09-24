<?php
namespace App\Lnky;

class UrlGenerator {
    private $allowed_chars = 'ABCDEFGHJKLMNPQRSTUVWXYXZabcdefghijkmnopqrstuvwxyz23456789_-';

    public function __construct() {
    }

    public function getRandomShortUrl($length) {
        $short = "";

        for($i = 0; $i < $length; $i++) {
            $base = str_shuffle($this->allowed_chars);
            $short .= @$base[rand(0, strlen($base))];
        }

        return $short;
    }
}