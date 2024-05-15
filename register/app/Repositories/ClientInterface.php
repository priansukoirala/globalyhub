<?php

namespace App\Repositories;

interface ClientInterface
{
    public function getAll($limit = null, $filter = [], $sortBy = ['by' => 'id', 'sort' => 'DESC']);

    public function find($username);

    public function store($data);

    public function storeCSV($data);

}
