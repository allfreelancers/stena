<?php

namespace App\Model;

use Webmozart\Assert\Assert;

class User
{
//    #[Assert\Length(
//        min: 2,
//        max: 50,
//        minMessage: 'Your first name must be at least {{ limit }} characters long',
//        maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
//    )]
//    protected ?string $name = null;

//    #[Assert\GreaterThan(
//        value: 18,
//    )]
//    protected ?int $age = null;

    public function __construct(
        private readonly string $name,
        private readonly int    $age
    )
    {
        //Assert::greaterThan($age, 20, 'The employee AGE must be a greater than 20. Got: %s');
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }
}