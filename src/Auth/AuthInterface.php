<?php declare(strict_types=1);

namespace GAMAFin\Auth;

use GAMAFin\Models\UserInterface;


interface AuthInterface
{
    public function login(array $creditentials) : bool;
    public function check() : bool;
    public function logout() : void;
    public function hashPassword(string $password) : string;
    public function user() :? UserInterface;

}