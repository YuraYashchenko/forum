<?php


namespace App\SpamDetection;


class KeyHeldDown implements DetectionInterface
{
    /**
     * Check if some button held down in the text.
     *
     * @param $text
     * @throws \Exception
     */
    public function detect($text)
    {
        if (preg_match('/(.)\\1{4,}/', $text))
        {
            throw new \Exception('Hold on detected');
        }
    }
}