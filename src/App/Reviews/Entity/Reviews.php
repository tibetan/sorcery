<?php

declare(strict_types=1);

namespace App\Reviews\Entity;

use Common\Exception\ValidationException;
use Common\Entity\AbstractEntity;
use Common\Entity\EntityInterface;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;
use Laminas\Validator\NumberComparison;
use MongoDB\BSON\Unserializable;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;

class Reviews extends AbstractEntity implements Unserializable, Serializable, EntityInterface
{
    private string $id;
    private int $rating = 0;
    private string $description;
    private string $reviewerName;
    private string $reviewerEmail;
    private string $productId;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;


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
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     * @return $this
     */
    public function setRating(int $rating): self
    {
        $this->rating = $this->validate('rating', $rating);
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
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getReviewerName(): string
    {
        return $this->reviewerName;
    }

    /**
     * @param string $reviewerName
     * @return $this
     */
    public function setReviewerName(string $reviewerName): self
    {
        $this->reviewerName = $this->validate('reviewer_name', $reviewerName);
        return $this;
    }

    /**
     * @return string
     */
    public function getReviewerEmail(): string
    {
        return $this->reviewerEmail;
    }

    /**
     * @param string $reviewerEmail
     * @return $this
     */
    public function setReviewerEmail(string $reviewerEmail): self
    {
        $this->reviewerEmail = $this->validate('reviewer_email', $reviewerEmail);
        return $this;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     * @return $this
     */
    public function setProductId(string $productId): self
    {
        $this->productId = $this->validate('product_id', $productId);
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
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt): self
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
            $dateTime = new \DateTime();
            $this->setId((string)($data['_id'] ?? new ObjectId()))
                ->setRating((int)$data['rating'])
                ->setDescription((string)$data['description'] ?? '')
                ->setReviewerName((string)$data['reviewer_name'] ?? '')
                ->setReviewerEmail((string)$data['reviewer_email'] ?? '')
                ->setProductId((string)$data['product_id'] ?? '')
                ->setCreatedAt(
                    (isset($data['created_at']) && ($data['created_at'] instanceof UTCDateTime))
                        ? $data['created_at']->toDateTime()
                        : $dateTime
                )
                ->setUpdatedAt(
                    (isset($data['updated_at']) && ($data['updated_at'] instanceof UTCDateTime))
                        ? $data['updated_at']->toDateTime()
                        : $dateTime
                );
        } catch (ValidationException $e) {
            $e->addAdditionalData([
                'review_id' => (string)$data['_id'] ?? 'undefined',
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
            'rating' => $this->getRating(),
            'description' => $this->getDescription(),
            'reviewer_name' => $this->getReviewerName(),
            'reviewer_email' => $this->getReviewerEmail(),
            'product_id' => ($this->getProductId() instanceof ObjectId)
                ? $this->getProductId()
                : (new ObjectId($this->getProductId())),
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
            'rating' => [
                NotEmpty::class => [
                    'break_chain' => true
                ],
                NumberComparison::class => [
                    'options' => ['min' => 0, 'max' => 5],
                    'break_chain' => true
                ]
            ],
            'reviewer_name' => [
                NotEmpty::class => [
                    'break_chain' => true
                ],
            ],
            'reviewer_email' => [
                NotEmpty::class => [
                    'break_chain' => true
                ],
                EmailAddress::class => [
                    'options' => ['allow' => true],
                    'break_chain' => true
                ]
            ],
            'product_id' => [
                NotEmpty::class => [
                    'break_chain' => true
                ],
                StringLength::class => [
                    'options' => ['min' => 24, 'max' => 24],
                    'break_chain' => true
                ]
            ],
        ];
    }
}
