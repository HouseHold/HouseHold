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

namespace App\Migrations\Security;

use App\Stock\Infrastructure\Share\Event\Repository\StockInventoryEventStore;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class Version20200107000000 extends AbstractMigration implements ContainerAwareInterface
{
    private EntityManager $em;

    private StockInventoryEventStore $stockEventStore;

    public function getDescription(): string
    {
        return 'Create event sourcing table for Stock/Inventory.';
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->stockEventStore = $container->get('event.store.stock.inventory');
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function up(Schema $schema): void
    {
        $this->stockEventStore->configureSchema($schema);
        $this->em->flush();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function down(Schema $schema): void
    {
        $schema->dropTable($this->stockEventStore->getTable());
        $this->em->flush();
    }
}
