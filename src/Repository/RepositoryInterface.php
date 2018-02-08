<?php declare(strict_types=1);

namespace GAMAFin\Repository;


interface RepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function delete($id);
}