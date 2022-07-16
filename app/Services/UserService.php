<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;

class UserService
{
  
  private $userRepo;
  
  public function __construct(UserRepositoryInterface $userRepo)
  {
    $this->userRepo = $userRepo;
  }

  public function getAllData()
  {
    return $this->userRepo->getAllData();
  }
}