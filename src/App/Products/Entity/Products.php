<?php

declare(strict_types=1);

namespace App\Products\Entity;

use Common\Exception\ValidationException;
use Common\Entity\AbstractEntity;
use Common\Entity\EntityInterface;
use Laminas\Validator\IsArray;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;
use Laminas\Validator\Callback;
use MongoDB\BSON\Unserializable;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;

class Products extends AbstractEntity implements Unserializable, Serializable, EntityInterface
{
    private string $id;
    private string $name;
    private array $images = [];
    private string $thumbnail = '';
    private float $price;
    private string $shortDescription;
    private string $description;
    private string $additionalInfo;
    private string $sku;
    private string $status;
    private \DateTime $createdAt;
    private ?\DateTime $updatedAt = null;

    /**
     * Products constructor.
     */
    public function __construct()
    {
        $dateTime = new \DateTime();
        $this->setId((string) new ObjectId());
        $this->setCreatedAt($dateTime);
        $this->setUpdatedAt($dateTime);
    }

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
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     * @return $this
     */
    public function setImages(array $images): self
    {
        $this->images = $this->validate('images', $images);
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     * @return $this
     */
    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $this->validate('thumbnail', $thumbnail);
        return $this;
    }

    /**
     * @return float
     * @return $this
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     * @return $this
     */
    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $this->validate('description', $description);
        return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalInfo(): string
    {
        return $this->additionalInfo;
    }

    /**
     * @param string $additionalInfo
     * @return $this
     */
    public function setAdditionalInfo(string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     * @return $this
     */
    public function setSku(string $sku): self
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $sku
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function bsonUnserialize(array $data): void
    {
        try {
            $this->setId((string)$data['_id'])
                ->setName((string)$data['name'] ?? '')
                ->setImages((array)$data['images'] ?? [])
                ->setThumbnail((string)$data['thumbnail'] ?? '')
                ->setPrice((float)$data['price'] ?? null)
                ->setShortDescription((string)$data['short_description'] ?? '')
                ->setDescription((string)$data['description'] ?? '')
                ->setAdditionalInfo((string)$data['additional_info'] ?? '')
                ->setSku((string)$data['sku'] ?? '')
                ->setStatus((string)$data['status'] ?? '')
                ->setCreatedAt($data['created_at']->toDateTime())
                ->setUpdatedAt(!empty($data['updated_at']) ? $data['updated_at']->toDateTime() : null);
        } catch (ValidationException $e) {
            $e->addAdditionalData([
                'product_id' => (string)$data['_id'] ?? 'undefined',
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
            '_id' => $this->getId(),
            'name' => $this->getName(),
            'images' => $this->getImages(),
            'thumbnail' => $this->getThumbnail(),
            'price' => $this->getPrice(),
            'short_description' => $this->getShortDescription(),
            'description' => $this->getDescription(),
            'additional_info' => $this->getAdditionalInfo(),
            'sku' => $this->getSku(),
            'status' => $this->getStatus(),
            'created_at' => new UTCDateTime($this->getCreatedAt()->getTimestamp() * 1000),
            'updated_at' => new UTCDateTime($this->getUpdatedAt()->getTimestamp() * 1000),
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
            'description' => [
                StringLength::class => [
                    'options' => ['max' => 2000, 'encoding' => 'UTF-8'],
                    'break_chain' => true
                ]
            ],
            'images' => [
                IsArray::class => [
                    'break_chain' => true
                ],
                new Callback(function($images) {
                    foreach ($images as $image) {
                        if (!preg_match(
                            "~^(http(s):\/\/.)[-a-zA-Z0-9@:%._\+\~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.\~#?&//=]*)$~",
                            $image
                        )){
                            return false;
                        }
                    }
                    return true;
                })
            ],
            'thumbnail' => [
                new Callback(function($thumbnail) {
                    if (!preg_match( //if URL or empty string
                        "~^((http(s):\/\/.)[-a-zA-Z0-9@:%._\+\~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.\~#?&//=]*))?$~",
                        $thumbnail
                    )){
                        return false;
                    }
                    return true;
                })
            ],
        ];
    }
}
