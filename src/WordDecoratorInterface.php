<?php

namespace CatCasCarSymfony\ArticleContentProviderBundle;

interface WordDecoratorInterface
{
    public function decorate(string $word, bool $isBold = true): string;
}