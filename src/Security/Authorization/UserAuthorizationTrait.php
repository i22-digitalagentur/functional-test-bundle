<?php

namespace I22\FunctionalTestBundle\Security\Authorization;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Dennis Langen <dennis.langen@i22.de>
 */
trait UserAuthorizationTrait
{
    /**
     * @return Client
     */
    abstract protected function getClient() : Client;

    /**
     * @param UserInterface $user
     * @param string $firewall
     */
    public function login(UserInterface $user, $firewall = 'default')
    {
        $session = $this->getClient()->getContainer()->get('session');
        $session->setId("test_session");

        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $this->getClient()->getContainer()->get('security.token_storage')->setToken($token);
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->getClient()->getCookieJar()->set($cookie);
    }
}