<?php

namespace App\Repositories;

use app\Helpers\ImageService;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Str;

class CustomerRepository
{
    public function get($request)
    {
        $customers = Customer::with('user')->orderBy('id', 'DESC');

        if (!empty($request->search)) {
            $customers = $customers->where('name', 'Like', '%' . $request->search . '%')
                ->orWhere('id', 'Like', '%' . $request->search . '%');
        }

        $customers = $customers->paginate(8);
        $customers->appends($request->all());
        return $customers;
    }

    public function count($request)
    {
        $customersCount = Customer::with('user')->orderBy('id', 'DESC');

        if (!empty($request->q)) {
            $customersCount = $customersCount->where('name', 'Like', '%' . $request->q . '%')
                ->orWhere('id', 'Like', '%' . $request->q . '%');
        }

        $customersCount = $customersCount->count();
        return $customersCount;
    }

    public static function store($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->birthdate),
            'role' => 'Customer',
            'random_key' => Str::random(60)
        ]);


        $customer = Customer::create([
            'name' => $user->name,
            'address' => $request->address,
            'job' => $request->job,
            'phone_number' => $request->phone_number,
            'code_bank' => $request->code_bank,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'user_id' => $user->id,
            'cni' => $request->cni,
            'passport_num' => $request->passport_num,
        ]);

        return $customer;
    }
}
