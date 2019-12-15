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

namespace App\Account\Application\EventSubscriber;

use App\Security\Domain\User\User;
use KevinPapst\AdminLTEBundle\Event\ShowUserEvent;
use KevinPapst\AdminLTEBundle\Event\SidebarUserEvent;
use KevinPapst\AdminLTEBundle\Model\UserModel;
use Ornicar\GravatarBundle\GravatarApi;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

final class NavbarUserSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var GravatarApi
     */
    private $gravatarApi;

    public function __construct(Security $security, GravatarApi $gravatarApi)
    {
        $this->security = $security;
        $this->gravatarApi = $gravatarApi;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return [
            NavbarUserEvent::class  => ['onShowUser', 100],
            SidebarUserEvent::class => ['onShowUser', 100],
        ];
    }

    /**
     * @throws \Exception
     */
    public function onShowUser(ShowUserEvent $event): void
    {
        if (null === $this->security->getUser()) {
            return;
        }

        // @var $current User
        $current = $this->security->getUser();
        $profile = $current->getProfile();
        $joined = new \DateTime();

        $user = new UserModel();
        $user
            ->setId($current->getUuid())
            ->setName($profile->getFirstname().' '.$profile->getLastname())
            ->setUsername($current->getUsername())
            ->setIsOnline(true)
            ->setTitle('TODO')
            ->setAvatar($this->gravatarApi->getUrl($current->getEmail()))
            ->setMemberSince($joined)
        ;

        $event->setUser($user);
    }
}
