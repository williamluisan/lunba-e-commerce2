<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Enums\Message;
use App\Http\Resources\Product\StockResource;
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
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'code' => 'required|min:4|max:6|alpha_num:ascii|uppercase|unique:products,code',
                'price' => 'required|numeric',
                'stock' => 'required|numeric|max:99'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $error = [
                'code' => Message::VALIDATION_FAILED->name,
                'message' => Message::VALIDATION_FAILED->value,
                'detail' => $e->errors()
            ];
            return $this->jsonResponse(422, false, Message::VALIDATION_FAILED->value, null, $error);
        }

        $data['public_id'] = (string) Str::ulid();

        Product::create($data);

        return $this->jsonResponse(201, true, Message::PRODUCT_CREATED->value);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $publicId)
    {
        // if valid ulid
        if ( ! Str::isUlid($publicId)) {
            return $this->jsonResponse(400, false, Message::INVALID_ULID->value);
        }

        $data = Product::where('public_id', $publicId)->first();
        if (empty($data)) {
            return $this->jsonResponse(404, false, Message::NOT_FOUND->value);
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

    /**
     * Check the product stock
     */
    public function checkStock(string $publicId) 
    {
        $data = Product::where('public_id', $publicId)->first();

        if (empty($data)) {
            return $this->jsonResponse(404, false, Message::NOT_FOUND->value);
        }

        if ($data->stock == 0) {
            return $this->jsonResponse(400, true, 'Stock not available', StockResource::make($data));
        }

        return $this->jsonResponse(200, true, 'Stock available', StockResource::make($data));
    }
}
