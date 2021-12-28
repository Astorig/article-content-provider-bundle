<?php

namespace CatCasCarSymfony\ArticleContentProviderBundle;

use CatCasCarSymfony\ArticleContentProviderBundle\Event\OnBeforeWordPasteEvent;
use Psr\EventDispatcher\EventDispatcherInterface;

class ArticleContentProvider
{
    private bool $isBold;
    private $paragraphs = [
        <<<EOF
            Привет, я параграф номер 1.


            EOF,
        <<<EOF
            Привет, я параграф номер 2.


            EOF,
        <<<EOF
            Привет, я параграф номер 3.


            EOF,
        <<<EOF
            Привет, я параграф номер 4.


            EOF,
        <<<EOF
            Привет, я параграф номер 5.


            EOF
    ];
    private WordDecoratorInterface $wordDecorator;
    private ?EventDispatcherInterface $dispatcher;

    public function __construct(WordDecoratorInterface $wordDecorator,EventDispatcherInterface $dispatcher = null, bool $isBold = true)
    {
        $this->isBold = $isBold;
        $this->wordDecorator = $wordDecorator;
        $this->dispatcher = $dispatcher;
    }


    public function getResultParagraphs(int $paragraphsCount)
    {
        $resultParagraphs = null;

        for ($i = 0; $i < $paragraphsCount; $i++) {
            $resultParagraphs .= $this->paragraphs[rand(0, count($this->paragraphs) - 1)];
        }

        return $resultParagraphs;
    }

    public function getResultParagraphsWithWord(int $paragraphsCount, string $word = null, int $wordsCount = 0)
    {
        $resultParagraphs = explode(' ', $this->getResultParagraphs($paragraphsCount));

        for ($i = 0; $i < $wordsCount; $i++) {
            $event = new OnBeforeWordPasteEvent($word);

            if (null !== $this->dispatcher) {
                $this->dispatcher->dispatch($event);
            }

            $resultParagraphs[rand(0, count($resultParagraphs) - 1)] .= ' ' . $this->wordDecorator->decorate($event->getWord(), $this->isBold);
        }

        return implode(' ', $resultParagraphs);
    }

    public function get(int $paragraphsCount, string $word = null, int $wordsCount = 0)
    {
        if ($word !== null && $wordsCount !== 0) {
            return $this->getResultParagraphsWithWord($paragraphsCount, $word, $wordsCount);
        } else {
            return $this->getResultParagraphs($paragraphsCount);
        }
    }
}
