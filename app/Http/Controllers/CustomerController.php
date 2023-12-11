<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\Customer as CustomerResource;
use App\Http\Requests\StoreCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = CustomerResource::collection(Customer::all()->keyBy->id);
        
        return response()->json($customers);
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
    public function store(StoreCustomerRequest $request)
    {
        $validatedCustomer = $request->validated();

        $customer = new Customer;
        $customer->full_name = $request->full_name;
        $customer->email_address = $request->email_address;
        $customer->phone_number = $request->phone_number;
        $customer->home_address = $request->home_address;
 
        $customer->save();

        return response('Success', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCustomerRequest $request, Customer $customer)
    {
        $validatedCustomer = $request->validated();

        $customer->full_name = $validatedCustomer['full_name'];
        $customer->email_address = $validatedCustomer['email_address'];
        $customer->phone_number = $validatedCustomer['phone_number'];
        $customer->home_address = $validatedCustomer['home_address'];
 
        $customer->save();

        return response('Success', 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response('Success', 200);
    }
}
