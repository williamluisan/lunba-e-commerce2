<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Enums\ErrorMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = User::all()->toResourceCollection();
        $data = User::paginate()->toResourceCollection();

        return $this->jsonResponse(200, true, '', $data);
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
    public function show(string $public_id)
    {
        // if valid ulid
        if ( ! Str::isUlid($public_id)) {
            return $this->jsonResponse(400, false, ErrorMessage::INVALID_ULID->value);
        }

        $data = User::where('public_id', $public_id)->first();
        if (empty($data)) {
            return $this->jsonResponse(404, false, ErrorMessage::USER_NOT_FOUND->value);
        }

        return $this->jsonResponse(200, true, '', $data->toResource());
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
