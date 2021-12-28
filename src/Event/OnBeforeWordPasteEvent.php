<?php

namespace CatCasCarSymfony\ArticleContentProviderBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class OnBeforeWordPasteEvent extends Event
{

    private string $word;

    public function __construct(string $word)
    {
        $this->word = $word;
    }

    /**
     * @return string
     */
    public function getWord(): string
    {
        return $this->word;
    }

    /**
     * @param string $word
     */
    public function setWord(string $word): void
    {
        $this->word = $word;
    }

}