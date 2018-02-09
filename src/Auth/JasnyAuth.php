<?php 

namespace GAMAFin\Auth;

use Jasny\Auth\Sessions;
use GAMAFin\Repository\RepositoryInterface;

class JasnyAuth extends \Jasny\Auth
{
    use Sessions;

	protected $repository;
 
	public function __construct(RepositoryInterface $repository)
	{
		$this->repository = $repository;
	}

	public function fetchUserByUsername($username)
	{
		return $this->repository->findByField('email', $username)[0];
	}

	public function fetchUserById($id)
	{
		return $this->repository->find($id);
	}

}