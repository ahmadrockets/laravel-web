<?php

namespace App\Repositories\Mysql;

use App\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
  private $model;
  public function __construct(User $model)
  {
    $this->model = $model;
  }
  public function getAllData()
  {
    return $this->model::all();
  }
}
