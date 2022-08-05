@extends('template.master')
@section('title', 'Edit Customer')
@section('content')
    <div class="row justify-content-md-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border">
                <div class="card-header">
                    <h2>Edit Customer</h2>
                </div>
                <div class="card-body p-3">
                    <form class="row g-3" method="POST"
                        action="{{ route('customer.update', ['customer' => $customer->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $customer->name }}">
                            @error('name')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"  id="email"
                                name="email" value="{{ $customer->user->email }}" disabled>
                            @error('email')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="cni" class="form-label">CNI</label>
                            <input type="text" class="form-control @error('cni') is-invalid @enderror" id="cni" name="cni"
                                value="{{ $customer->cni }}">
                                <br>
                               
                                <div class="mt-1">
                                    *optional
                                </div>
                            @error('cni')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="passport_num" class="form-label">Passport Number</label>
                            <input type="text" class="form-control @error('cni') is-invalid @enderror" id="passport_num" name="passport_num"
                                value="{{ $customer->passport_num }}">
                                <br>
                                <div class="mt-1">
                                    *optional
                                </div>
                            @error('passport_num')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="birthdate" class="form-label">Date of birth</label>
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate"
                                name="birthdate" value="{{ $customer->birthdate }}">
                            @error('birthdate')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="job" class="form-label">Job</label>
                            <input type="text" class="form-control @error('job') is-invalid @enderror" id="job" name="job"
                                value="{{ $customer->job }}">
                            @error('job')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="code_bank" class="form-label">Bank code</label>
                            <input type="text" class="form-control @error('code_bank') is-invalid @enderror" id="code_bank" name="code_bank"
                                value="{{ $customer->code_bank }}">
                            @error('code_bank')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address"
                                rows="3">{{ $customer->address }}</textarea>
                            @error('address')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn myBtn shadow-sm border float-end">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
