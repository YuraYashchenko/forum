<?php


namespace App\SpamDetection;


interface DetectionInterface
{
    public function detect($text);
}