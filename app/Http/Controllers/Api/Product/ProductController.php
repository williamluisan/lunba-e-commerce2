<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Enums\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::all();

        return $this->jsonResponse(200, true, '', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'code' => 'required|min:4|max:6|alpha_num:ascii|uppercase|unique:products,code',
            'price' => 'required|numeric',
            'stock' => 'required|numeric|max:99'
        ]);

        $data['public_id'] = (string) Str::ulid();

        Product::create($data);

        return $this->jsonResponse(201, true, Message::PRODUCT_CREATED->value);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $public_id)
    {
        $data = Product::where('public_id', $public_id)->first();
        if (empty($data)) {
            return $this->jsonResponse(404, false, Message::NOT_FOUND->value);
        }

        return $this->jsonResponse(200, true, '', $data);
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
