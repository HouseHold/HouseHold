<?php

declare(strict_types=1);

/**
 *
 * Household 2019 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2019 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2019 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Core\Infrastructure\ExampleUser\Specification;

use App\Core\Domain\ExampleUser\Exception\EmailAlreadyExistException;
use App\Core\Domain\ExampleUser\Repository\CheckExampleUserByEmailInterface;
use App\Core\Domain\ExampleUser\Specification\UniqueEmailSpecificationInterface;
use App\Core\Domain\ExampleUser\ValueObject\Email;
use App\Core\Domain\Shared\Specification\AbstractSpecification;
use Doctrine\ORM\NonUniqueResultException;

final class UniqueEmailSpecification extends AbstractSpecification implements UniqueEmailSpecificationInterface
{
    /**
     * @throws EmailAlreadyExistException
     */
    public function isUnique(Email $email): bool
    {
        return $this->isSatisfiedBy($email);
    }

    /**
     * @param Email $value
     */
    public function isSatisfiedBy($value): bool
    {
        try {
            if ($this->checkUserByEmail->existsEmail($value)) {
                throw new EmailAlreadyExistException();
            }
        } catch (NonUniqueResultException $e) {
            throw new EmailAlreadyExistException();
        }

        return true;
    }

    public function __construct(CheckExampleUserByEmailInterface $checkUserByEmail)
    {
        $this->checkUserByEmail = $checkUserByEmail;
    }

    /**
     * @var CheckExampleUserByEmailInterface
     */
    private $checkUserByEmail;
}
