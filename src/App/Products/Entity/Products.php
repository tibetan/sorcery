<?php

declare(strict_types=1);

namespace App\Products\Entity;

use Common\Exception\ValidationException;
use Common\Entity\AbstractEntity;
use Common\Entity\EntityInterface;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;
use MongoDB\BSON\Unserializable;

class Products extends AbstractEntity implements Unserializable, EntityInterface
{
    protected string $id;
    protected string $title;
//    protected string $item;
//    protected float $qty;
//    protected string $type;
//    protected string $topicId;
//    protected string $message;
//    protected \DateTime $dtCreated;
//    protected ?\DateTime $dtUpdated = null;
//    protected string $creator;
//    protected array $subscribersRead = [];

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $this->validate('id', $id);
        return $this;
    }

//    public function getTopicId(): string
//    {
//        return $this->topicId;
//    }
//
//    public function setTopicId(string $topicId): self
//    {
//        $this->topicId = $topicId;
//        return $this;
//    }
//
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $this->validate('title', $title);
        return $this;
    }
//
//    public function getDtCreated(): \DateTime
//    {
//        return $this->dtCreated;
//    }
//
//    public function setDtCreated(\DateTime $dtCreated): self
//    {
//        $this->dtCreated = $dtCreated;
//        return $this;
//    }
//
//    public function getDtUpdated(): ?\DateTime
//    {
//        return $this->dtUpdated;
//    }
//
//    public function setDtUpdated(?\DateTime $dtUpdated): self
//    {
//        $this->dtUpdated = $dtUpdated;
//        return $this;
//    }
//
//    public function getCreator(): string
//    {
//        return $this->creator;
//    }
//
//    public function setCreator(string $creator): self
//    {
//        $this->creator = $creator;
//        return $this;
//    }
//
//    public function getSubscribersRead(): array
//    {
//        return $this->subscribersRead;
//    }
//
//    public function setSubscribersRead(array $subscribersRead): self
//    {
//        $this->subscribersRead = $subscribersRead;
//        return $this;
//    }
//

//    public function bsonSerialize(): array
//    {
//        return [
//            '_id' => $this->id,
//            'title' => $this->title,
//        ];
//    }

    public function bsonUnserialize(array $data): void
    {
        try {
            $this->setId((string)$data['_id']);
            $this->setTitle((string)$data['title'] ?? '');
//            $this->setTitle(mb_substr($data['title'] ?? '', 0, 999, 'UTF-8'));
//                ->setMessage(mb_substr($data['message'] ?? '', 0, 999, 'UTF-8'))
//                ->setDtCreated(!empty($data['dt_created']) ? $data['dt_created']->toDateTime() : null)
//                ->setDtUpdated(!empty($data['dt_updated']) ? $data['dt_updated']->toDateTime() : null)
//                ->setCreator($data['creator'])
//                ->setSubscribersRead($data['subscribers_read'])
            ;
        } catch (ValidationException $e) {
            $e->addAdditionalData([
                'product_id' => (string)$data['_id'] ?? 'undefined',
//                'topic_id' => (string)$data['topic_id'] ?? 'undefined'
            ]);
            throw $e;
        }
    }

//    public function getItem(): string
//    {
//        return $this->item;
//    }
//
//    public function setItem(string $item): self
//    {
//        $this->item = $item;
//        return $this;
//    }
//
//    public function getQty(): float
//    {
//        return $this->qty;
//    }
//
//    public function setQty(float $qty): self
//    {
//        $this->qty = $qty;
//        return $this;
//    }
//
//    public function getType(): string
//    {
//        return $this->type;
//    }
//
//    public function setType(string $type): self
//    {
//        $this->type = $type;
//        return $this;
//    }

//    public function bsonUnserialize(array $data)
//    {
//        $this->setId((string)$data['_id'])
////            ->setItem((string)$data['item'] ?? '')
////            ->setQty((float)$data['qty'] ?? 0)
////            ->setType((string)$data['type'] ?? '')
////            ->setTopicId((string)$data['topic_id'] ?? '')
////            ->setMessage(mb_substr($data['message'] ?? '', 0, 999, 'UTF-8'))
////            ->setDtCreated(!empty($data['dt_created']) ? $data['dt_created']->toDateTime() : null)
////            ->setDtUpdated(!empty($data['dt_updated']) ? $data['dt_updated']->toDateTime() : null)
////            ->setCreator($data['creator'])
////            ->setSubscribersRead($data['subscribers_read'])
//        ;
//    }

    public function validators(): array
    {
        return [
            'id' => [
                NotEmpty::class => [
                    'break_chain' => true
                ],
                StringLength::class => [
                    'options' => ['min' => 1, 'max' => 24],
                    'break_chain' => true
                ]
            ],
            'title' => [
                NotEmpty::class => [
                    'break_chain' => true
                ],
                StringLength::class => [
                    'options' => ['min' => 1, 'max' => 1000, 'encoding' => 'UTF-8'],
                    'break_chain' => true
                ]
            ]
        ];
    }
}
