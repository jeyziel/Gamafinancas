<?php declare(strict_types=1);

namespace GAMAFin\Repository;


interface StatementsRepositoryInterface
{
    public function all(string $dateStart, string $dateEnd, int $userId) : array;
}