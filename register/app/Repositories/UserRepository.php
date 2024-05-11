<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserInterface
{

    public function getAll($limit = null, $filter = [], $sortBy = ['by' => 'id', 'sort' => 'DESC'])
    {
        $users = User::when(array_key_exists('', $filter), function ($query) use ($filter) {
            return $query->where('first_name', $filter['first_name']);
        })->orderBy($sortBy['by'], $sortBy['sort'])->paginate($limit ? $limit : 999);

        return $users;
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function store($data)
    {
        return User::create($data);
    }
}