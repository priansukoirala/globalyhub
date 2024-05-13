<?php

namespace App\Http\Controllers;

use App\ApiCode;
use App\Repositories\UserInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        $user = $this->user->find($id);

        return $this->respond($user);
    }

    public function index(Request $request)
    {
        $search = $request->all();
        return $this->respond($this->user->getAll($limit = 50, $search));
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
            return response()->json(['errors' => $validator->errors()], ApiCode::VALIDATION_ERROR);
        }
        $data = $request->all();
        try {
            return DB::transaction(function () use ($data) {

                $storedData = $this->respond($this->user->storeCSV($data));

                return $storedData;
            });
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
