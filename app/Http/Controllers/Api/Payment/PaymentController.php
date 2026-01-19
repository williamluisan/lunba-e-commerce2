<?php

namespace App\Http\Controllers\Api\Payment;

use App\Jobs\ProcessPaymentJob;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpAmqpLib\Message\AMQPMessage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|string',
            'amount' => 'required|decimal:2'
        ]);

        // laravel style, to consume by php
        ProcessPaymentJob::dispatch($data)->onQueue('payments');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
