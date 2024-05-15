<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository implements ClientInterface
{

    public function getAll($limit = null, $filter = [], $sortBy = ['by' => 'id', 'sort' => 'DESC'])
    {
        $clients = Client::when(array_key_exists('', $filter), function ($query) use ($filter) {
            return $query->where('first_name', $filter['first_name']);
        })->orderBy($sortBy['by'], $sortBy['sort'])->paginate($limit ? $limit : 999);

        return $clients;
    }

    public function find($id)
    {
        return Client::findOrFail($id);
    }

    public function store($data)
    {
        return Client::create($data);
    }

    public function storeCSV($data)
    {
        $csvFileName = 'clients.csv';
        $csvFile = fopen(storage_path('app/' . $csvFileName), 'a');

        if (filesize(storage_path('app/' . $csvFileName)) === 0) {
            fputcsv($csvFile, array_keys($data));
        }

        fputcsv($csvFile, $data);

        fclose($csvFile);

        $this->store($data);
    }
}
