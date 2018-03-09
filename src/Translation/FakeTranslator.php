<?php

namespace I22\FunctionalTestBundle\Translation;

use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Manuel Voss <manuel.voss@i22.de>
 */
class FakeTranslator implements TranslatorInterface, TranslatorBagInterface
{
    /**
     * @param string $id
     * @param array $parameters
     * @param null $domain
     * @param null $locale
     * @return string
     */
    public function trans($id, array $parameters = array(), $domain = null, $locale = null) : string
    {
        return $id;
    }

    /**
     * @param string $id
     * @param int $number
     * @param array $parameters
     * @param null $domain
     * @param null $locale
     * @return string
     */
    public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null) : string
    {
        return $id;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale) : void
    {
        return;
    }

    /**
     * @return string
     */
    public function getLocale() : string
    {
        return '--';
    }

    /**
     * @param null $locale
     * @return MessageCatalogue
     */
    public function getCatalogue($locale = null) : MessageCatalogue
    {
        return new MessageCatalogue('--');
    }
}
