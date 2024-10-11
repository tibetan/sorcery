<?php

declare(strict_types=1);

namespace App\Categories\Entity;

use Common\Exception\ValidationException;
use Common\Entity\AbstractEntity;
use Common\Entity\EntityInterface;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;
use Laminas\Validator\Regex;
use MongoDB\BSON\Unserializable;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\ObjectId;

class Categories extends AbstractEntity implements Unserializable, Serializable, EntityInterface
{
    private string $id;
    private string $slug;
    private string $name;


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $this->validate('id', $id);
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $this->validate('slug', $slug);
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $this->validate('name', $name);
        return $this;
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function bsonUnserialize(array $data): void
    {
        try {
            $this->setId((string)($data['_id'] ?? new ObjectId()))
                ->setSlug((string)$data['slug'])
                ->setName((string)$data['name']);
        } catch (ValidationException $e) {
            $e->addAdditionalData([
                'category_id' => (string)$data['_id'] ?? 'undefined',
            ]);
            throw $e;
        }
    }

    /**
     * @return array
     */
    public function bsonSerialize(): array
    {
        return [
            '_id' => new ObjectId($this->getId()),
            'slug' => $this->getSlug(),
            'name' => $this->getName(),
        ];
    }

    public function validators(): array
    {
        return [
            'id' => [
                NotEmpty::class => [
                    'break_chain' => true
                ],
                StringLength::class => [
                    'options' => ['min' => 24, 'max' => 24],
                    'break_chain' => true
                ]
            ],
            'slug' => [
                NotEmpty::class => [
                    'break_chain' => true
                ],
                Regex::class => [
                    'options' => ['pattern' => '/^\S+$/'],
                    'break_chain' => true
                ],
            ],
            'name' => [
                NotEmpty::class => [
                    'break_chain' => true
                ],
            ],
        ];
    }
}
