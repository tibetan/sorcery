<?php

namespace Common\Entity;

interface EntityInterface
{
    public function getId(): string;
    public function setId(string $id): self;
}