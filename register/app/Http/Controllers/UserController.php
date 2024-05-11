<?php

namespace App\Http\Controllers;

use App\Repositories\UserInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    protected $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $search = $request->all();
        return $this->respond($this->user->getAll($limit = 50, $search));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try{
            return DB::transaction(function () use ($data) {

                $storedData = $this->respond($this->user->store($data));

                return $storedData;
            });
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
