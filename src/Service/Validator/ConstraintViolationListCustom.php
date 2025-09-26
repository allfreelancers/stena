<?php

declare(strict_types=1);
namespace App\Service\Validator;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Autoconfigure(public: true)]
class ConstraintViolationListCustom
{
    public function getErrorList(ConstraintViolationListInterface $validator): array
    {
        $errorList = [];
        foreach ($validator as $violation) {
            /** @var ConstraintViolation $violation */
            $errorList[$violation->getPropertyPath()] = $violation->getMessage();
        }
        return $errorList;
    }

    private function clearField(string $field): string
    {
        return str_replace(['[', ']'], '', $field);
    }
}