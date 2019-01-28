<?php

declare(strict_types=1);

namespace App\Http\v1\Serializer;


use App\Http\v1\Action\Group\Request\UserContainerInterface;
use App\Model\UserInterface;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class GroupDenormalizer implements DenormalizerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ObjectNormalizer
     */
    private $objectNormalizer;

    public function __construct(UserRepository $userRepository, ObjectNormalizer $objectNormalizer)
    {
        $this->userRepository = $userRepository;
        $this->objectNormalizer = $objectNormalizer;
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        /**
         * @var UserContainerInterface $object
         */
        $object = $this->objectNormalizer->denormalize($data, $class, $format, $context);

        if (is_array($data['user_ids'])) {
            $object->setUsers($this->objectsFromIds($data['user_ids']));
        }

        return $object;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return is_subclass_of($type, UserContainerInterface::class);
    }

    private function objectsFromIds(array $ids): array
    {
        $objects = [];
        foreach ($ids as $id) if (is_integer($id)) {
            $objects[] = $this->findOneOrThrowException($id);
        }

        return $objects;
    }

    private function findOneOrThrowException($id): UserInterface
    {
        $user = $this->userRepository->findOneById($id);
        if (!$user instanceof UserInterface) {
            throw new UnexpectedValueException('Unknown user id supplied.');
        }

        return $user;
    }
}