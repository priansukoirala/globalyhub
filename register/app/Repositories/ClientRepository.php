<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use SplFileObject;

class ClientRepository implements ClientInterface
{

    public function getAll($limit = null, $filter = [], $sortBy = ['by' => 'id', 'sort' => 'DESC'])
    {
        $clients = Client::when(array_key_exists('', $filter), function ($query) use ($filter) {
            return $query->where('first_name', $filter['first_name']);
        })->orderBy($sortBy['by'], $sortBy['sort'])->paginate($limit ? $limit : 999);

        return $clients;
    }

    public function getAllFromCSV()
    {
        $filePath = storage_path('app/clients.csv');
        $clients = [];
        $fin_clients = [];

        if (file_exists($filePath)) {
            $file = new SplFileObject($filePath, 'r');
            $file->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

            foreach ($file as $row) {
                $clients[] = $row;
            }
            for ($i = 1; $i < count($clients); $i++) {
                $fin_clients[] = array_combine($clients[0], $clients[$i]);
            }
        }

        $perPage = 10;
        $currentPage = request()->get('page', 1);

        $clientCollection = new Collection($fin_clients);
        $paginatedClients = $clientCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator($paginatedClients, count($clientCollection), $perPage, $currentPage, [
            'path' => url()->current()
        ]);

        return $paginator;
    }

    public function find($username)
    {
        return Client::where('username', $username)->first();
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
