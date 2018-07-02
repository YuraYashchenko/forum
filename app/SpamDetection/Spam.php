<?php


namespace App\SpamDetection;


class Spam
{
    protected $inspections = [
        InvalidKeyWords::class,
        KeyHeldDown::class
    ];

    /**
     * Check all inspections.
     *
     * @param $text
     */
    public function detect($text)
    {
        foreach ($this->inspections as $inspection)
        {
            app($inspection)->detect($text);
        }
    }
}