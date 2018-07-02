<?php


namespace App\SpamDetection;


class InvalidKeyWords implements  DetectionInterface
{
    protected $keywords = [
        'yahoo customer support'
    ];

    /**
     * Check the text for invalid keywords.
     *
     * @param $text
     * @throws \Exception
     */
    public function detect($text)
    {
        foreach ($this->keywords as $keyword)
        {
            if (stripos($text, $keyword) !== false)
            {
                throw new \Exception();
            }
        }
    }
}