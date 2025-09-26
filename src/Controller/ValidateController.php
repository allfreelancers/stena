<?php

namespace App\Controller;


use App\Model\User;
use App\Service\Validator\ConstraintViolationListCustom;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ValidateController extends AbstractController
{
    private array $data = [
        ['name' => 'Jon', 'years' => 20],
        ['name' => 'Marry', 'years' => 18],
        ['name' => 'Smit', 'years' => 25],
    ];

    #[Route('/validate', name: 'validate')]
    public function index(
        ValidatorInterface $validator,
        ConstraintViolationListCustom $constraintViolationListCustom
    )
    {
        // Create Normalizers and Encoders
        $normalizers = [new ObjectNormalizer()];
        $encoders = [new JsonEncoder()]; // Only needed if you're working with a serialized string, not a plain array

        // Instantiate the Serializer
        $serializer = new Serializer($normalizers, $encoders);

        // The array you want to convert
        $data = [
            'name' => 'John Doe',
            'age' => 18,
        ];

        $constraints = new Collection([
            'name' => [
                new Assert\NotBlank(),
                new Assert\Type(['string']),
                new Assert\Length(
                    min: 3,
                    max: 5,
                    minMessage: 'Необходимо ввести не менее 3 символов',
                    maxMessage: 'Необходимо ввести не больше 10 символов'
                )
            ],
            'age' => [
                new Assert\NotBlank(),
                new Assert\Type(['integer']),
                new Assert\GreaterThanOrEqual(19),
                new Assert\LessThanOrEqual(60),
            ]
        ]);

        $errors = $validator->validate($data, $constraints);

        if ($errors->count() > 0) {
            return new JsonResponse([
                'message' => $constraintViolationListCustom->getErrorList($errors),
            ], Response::HTTP_BAD_REQUEST);
        }

        // Denormalize the array into an object of type MyObject
        $user = $serializer->denormalize($data, User::class, 'json');

        dd($user);
//        // Now $user is an instance of MyObject with the data populated
//        echo $user->getName(); // Outputs: John Doe
//        echo $user->getAge();  // Outputs: 30

        return $this->render('validate/index.html.twig', [

        ]);
    }
}
