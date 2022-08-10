@extends('template.master')
@section('title', 'Customer')
@section('content')
    <div class="container">
        {{-- @dd($customer) --}}
        <div class="card">
            <div class="card-header">
                <h3>User Details for : {{ $customer->name }}</h3>
            </div>
            <div class="card-body">
                <div class="row g-0 bg-light position-relative">
                    <div class="col-md-4 mb-md-0 p-md-4">
                        <img src="{{ $customer->user->getAvatar() }}" class="w-100" alt="...">
                    </div>
                    <div class="col-md-8 p-4 ps-md-0">
                        <p><i class="fa-solid fa-user"></i> Name : {{ $customer->name }} </p>
                        <p><i class="fa-solid fa-location-dot"></i> Addrees: {{ $customer->address }} </p>
                        <p><i class="fa-solid fa-at"></i> Addrees: {{ $customer->user->email }} </p>
                        {{-- <p><i class="fas fa-user-md"></i> Job :  {{ $customer->job }}</p>   --}}
                        <p> <i class="fas fa-phone"></i> Phone number :  {{ $customer->phone_number }}</p>

                        <p><i class="fas fa-birthday-cake"></i> Birthday :  {{ $customer->birthdate }}</p>  
                        <p><i class="fas fa-passport"></i> Passport Number : {{ $customer->passport_num }}</p>  
                        <p> <i class="fa-solid fa-money-check-dollar"></i> Bank code  :  {{ $customer->code_bank }}</p>  
                        <p> <i class="fa-solid fa-barcode"></i> Code CNI  :  {{ $customer->cni }}</p>  
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

