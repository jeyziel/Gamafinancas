<?php
/**
 * Created by PhpStorm.
 * User: jeyziel
 * Date: 07/02/18
 * Time: 18:58
 */

namespace GAMAFin\View\Twig;


use GAMAFin\Auth\AuthInterface;

class TwigGlobals extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var AuthInterface
     */
    private $auth;

    /**
     * TwigGlobals constructor.
     */
    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    public function getGlobals()
    {
        return [
            'Auth' => $this->auth
        ];
    }
}