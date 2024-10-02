<?php

declare(strict_types=1);

namespace Common\Entity;

use Common\Exception\ValidationException;
use Laminas\Validator\ValidatorChain;
use Laminas\Validator\ValidatorInterface;
use MongoDB\BSON\Unserializable;

abstract class AbstractEntity implements EntityInterface, Unserializable
{
    protected function validate(string $paramName, $paramValue)
    {
        $validatorChain = new ValidatorChain();
        foreach ($this->validators() as $validationParamName => $validators) {
            if ($validationParamName != $paramName) continue;
            foreach ($validators as $validatorName => $validatorParams) {
                if ($validatorParams instanceof ValidatorInterface) {
                    $validatorChain->attach($validatorParams);
                } else {
                    $validatorChain->attach(
                        new $validatorName($validatorParams['options'] ?? null),
                        $validatorParams['break_chain'] ?? false
                    );
                }
            }
        }

        if (!$validatorChain->isValid($paramValue)) {
            throw ValidationException::wrongParameter(
                sprintf('Validation error field `%s`', $paramName),
                $validatorChain->getMessages()
            );
        }
        return $paramValue;
    }

    abstract protected function validators(): array;
}
