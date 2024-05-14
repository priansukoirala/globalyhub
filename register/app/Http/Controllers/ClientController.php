<?php

namespace App\Http\Controllers;

use App\ApiCode;
use App\Repositories\ClientInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    protected $client;
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function show($id)
    {
        $client = $this->client->find($id);

        return $this->respond($client);
    }

    public function index(Request $request)
    {
        $search = $request->all();
        return $this->respond($this->client->getAll($limit = 50, $search));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            // 'middle_name' => 'string',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'address' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'dob' => 'required|date',
            'education' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return $this->respondErrorWithMessage($message, ApiCode::FORBIDDEN, ApiCode::FORBIDDEN);
        }
        $data = $request->all();
        $data['username'] = strtolower($data['first_name']) . strtolower($data['last_name']) . mt_rand(10, 99);
        try {
            return DB::transaction(function () use ($data) {

                $storedData = $this->respond($this->client->storeCSV($data));

                return $storedData;
            });
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    public function download($filename)
    {
        // $filename = 'clients.csv';
        $filePath = storage_path('app/' . $filename);
        
        if (!Storage::exists($filename)) {
            abort(404);
        }
        return response()->download($filePath, $filename);
    }
}
