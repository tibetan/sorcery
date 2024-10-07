<?php

declare(strict_types=1);

namespace App\Reviews\Storage;

use App\Reviews\Entity\Reviews;
use App\Reviews\Entity\ReviewsCollection;
use Common\Storage\AbstractStorage;

class ReviewsStorage extends AbstractStorage
{
    public function getCollectionName(): string
    {
        return 'reviews';
    }

    public function getEntityName(): string
    {
        return Reviews::class;
    }

    public function getEntityCollectionName(): string
    {
        return ReviewsCollection::class;
    }
}
