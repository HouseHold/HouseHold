<?php

declare(strict_types=1);

/**
 *
 * Household 2020 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2020 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2020 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Core\Infrastructure\Share\Event\Metadata;

use App\Security\Domain\User\User;
use Broadway\Domain\Metadata;
use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

final class UserMetadata implements MetadataEnricher
{
    /**
     * @var Security
     */
    private Security $security;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function enrich(Metadata $metadata): Metadata
    {
        if (\PHP_SAPI === 'cli') {
            $user = $this->em->getRepository(User::class)->findOneBy(['id' => User::ADMIN_ID]);

            return $metadata->merge(new Metadata([
                'user' => [
                    'id'       => $user->getId(),
                    'username' => $user->username,
                    'roles'    => array_merge($user->roles, ['cli']),
                ],
            ]));
        }

        if (null === $this->security->getUser() && null === $this->security->getToken() && \PHP_SAPI !== 'cli') {
            throw new \LogicException('Smells like a bug and hacking at same time.'); // Should never happen.
        }

        throw new \LogicException('No logic implemented, please do so.'); //TODO: Check exception.
    }
}
