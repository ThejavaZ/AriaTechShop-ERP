<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('is_active', 1)->get();

        if($users){
            $list = [];

            foreach($users as $user){
                $object = [
                    'message' => [
                        'code' => 202,
                        'message' => 'All users'
                    ],
                    'id' => $user->id,
                ];

                array_push($list, $object);
            }
            return response()->json($list);
        }

        else{
            $object = [
                'code' => 404,
                'message' => "No info"
            ];

            return response()->json($object);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
