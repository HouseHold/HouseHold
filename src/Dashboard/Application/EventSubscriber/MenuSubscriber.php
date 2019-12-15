<?php

/**
 *
 * Household 2019 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2019 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2019 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Dashboard\Application\EventSubscriber;

use App\Core\Application\EventSubscriber\AbstractMenuSubscriber;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;

final class MenuSubscriber extends AbstractMenuSubscriber
{
    public function onSetupMenu(KnpMenuEvent $event): void
    {
        $event->getMenu()->addChild('dashboard', [
            'route'        => 'home',
            'label'        => 'Dashboard',
            'childOptions' => $event->getChildOptions(),
        ])->setLabelAttribute('icon', 'fas fa-tachometer-alt');
    }
}
