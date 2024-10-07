<?php

use Mezzio\Hal\Metadata\MetadataMap;
use Mezzio\Hal\Metadata\RouteBasedCollectionMetadata;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;
use Laminas\Hydrator\ClassMethodsHydrator;
use App\Products\Entity\Products;
use App\Products\Entity\ProductsCollection;
use App\Reviews\Entity\Reviews;
use App\Reviews\Entity\ReviewsCollection;

return [
    MetadataMap::class => [
//        [
//            '__class__' => RouteBasedResourceMetadata::class,
//            'resource_class' => Entity\Topic::class,
//            'route' => 'api.topic',
//            'extractor' => ClassMethodsHydrator::class,
//        ],
//        [
//            '__class__' => RouteBasedCollectionMetadata::class,
//            'collection_class' => Entity\TopicCollection::class,
//            'collection_relation' => 'api.topic',
//            'route' => 'api.topics',
//        ],
        [
            '__class__' => RouteBasedResourceMetadata::class,
            'resource_class' => Products::class,
            'route' => 'api.get.product',
            'extractor' => ClassMethodsHydrator::class,
        ],
        [
            '__class__' => RouteBasedCollectionMetadata::class,
            'collection_class' => ProductsCollection::class,
            'collection_relation' => 'api.get.product',
            'route' => 'api.get.products',
        ],
        [
            '__class__' => RouteBasedResourceMetadata::class,
            'resource_class' => Reviews::class,
            'route' => 'api.get.review',
            'extractor' => ClassMethodsHydrator::class,
        ],
        [
            '__class__' => RouteBasedCollectionMetadata::class,
            'collection_class' => ReviewsCollection::class,
            'collection_relation' => 'api.get.review',
            'route' => 'api.get.reviews',
        ],
    ],
];
