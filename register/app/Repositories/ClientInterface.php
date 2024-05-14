<?php

namespace App\Repositories;

interface ClientInterface
{
    public function getAll($limit = null, $filter = [], $sortBy = ['by' => 'id', 'sort' => 'DESC']);

    public function find($id);

    public function store($data);

    public function storeCSV($data);
}