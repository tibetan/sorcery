<?php

declare(strict_types=1);

namespace App\Reviews\Entity;

use Common\Entity\CollectionInterface;
use Laminas\Paginator\Paginator;

class ReviewsCollection extends Paginator implements CollectionInterface
{
    /**
     * Need disable default exception, because it clover validation exception
     */
    public function getIterator()
    {
        return $this->getCurrentItems();
    }
}
