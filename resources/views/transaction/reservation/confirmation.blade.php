@extends('template.master')
@section('title', 'Choose Day Reservation')
@section('head')
    <link rel="stylesheet" href="{{ asset('style/css/progress-indication.css') }}">
@endsection
@section('content')
    @include('transaction.reservation.progressbar')
    <div class="container mt-3">
        <div class="row justify-content-md-center">
            <div class="col-md-8 mt-2">
                <div class="card shadow-sm border">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row mb-3">
                                    <label for="room_number" class="col-sm-2 col-form-label">Room</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="room_number" name="room_number"
                                            placeholder="col-form-label" value="{{ $room->number }} " readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="room_type" class="col-sm-2 col-form-label">Type</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="room_type" name="room_type"
                                            placeholder="col-form-label" value="{{ $room->type->name }} " readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="room_capacity" class="col-sm-2 col-form-label">Capacity</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="room_capacity" name="room_capacity"
                                            placeholder="col-form-label" value="{{ $room->capacity }} " readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="room_price" class="col-sm-2 col-form-label">Price / Day</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="room_price" name="room_price"
                                            placeholder="col-form-label"
                                            value="{{ Helper::convertToRupiah($room->price) }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-sm-12 mt-2">
                                <form method="POST"
                                    action="{{ route('transaction.reservation.payDownPayment', ['customer' => $customer->id, 'room' => $room->id]) }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="check_in" class="col-sm-2 col-form-label">Check In</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="check_in" name="check_in"
                                                placeholder="col-form-label" value="{{ $stayFrom }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="check_out" class="col-sm-2 col-form-label">Check Out</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="check_out" name="check_out"
                                                placeholder="col-form-label" value="{{ $stayUntil }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="how_long" class="col-sm-2 col-form-label">Total Day</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="how_long" name="how_long"
                                                placeholder="col-form-label"
                                                value="{{ $dayDifference }} {{ Helper::plural('Day', $dayDifference) }} "
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="how_long" class="col-sm-2 col-form-label">Number of adults</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="adult_num" name="adults_num"
                                                placeholder="col-form-label"
                                                value="{{ $adult_num }} "
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="kids_num" class="col-sm-2 col-form-label">Number of kids</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="kids_num" name="kids_num"
                                                placeholder="col-form-label"
                                                value="{{ $kids_num }} "
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="total_price" class="col-sm-2 col-form-label">Total Price</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="total_price" name="total_price"
                                                placeholder="col-form-label"
                                                value="{{ Helper::getTotalPayment($dayDifference, $room->price) }} "
                                                readonly>
                                        </div>
                                    </div>
                                    {{-- TPT --}}
                                    <div class="row mb-3">
                                        <label for="tpt" class="col-sm-2 col-form-label">TPT</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="tpt" name="tpt"
                                                placeholder="col-form-label"
                                                value="{{ ($adult_num + $kids_num) * 8 }} "
                                                readonly>
                                        </div>
                                    </div>
                                    {{-- TS --}}
                                    <div class="row mb-3">
                                        <label for="ts" class="col-sm-2 col-form-label">TS</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="ts" name="ts"
                                                placeholder="col-form-label"
                                                value="{{ $adult_num * 7 * $dayDifference  }} "
                                                readonly>
                                        </div>
                                    </div>
                                    {{-- TPT --}}
                                    <div class="row mb-3">
                                        <label for="tva" class="col-sm-2 col-form-label">TVA</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="tva" name="tva"
                                                placeholder="col-form-label"
                                                value="{{ 0.1 * (Helper::getTotalPayment($dayDifference, $room->price) + ($adult_num * 7 * $dayDifference) +  (($adult_num + $kids_num) * 8) ) }} "
                                                readonly>
                                        </div>
                                    </div>
                                    {{-- TTOTAL TTC--}}
                                    <div class="row mb-3">
                                        <label for="total_ttc" class="col-sm-2 col-form-label">Total TTC</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="total_ttc" name="price"
                                                placeholder="col-form-label"
                                                value="{{ (0.1 * (Helper::getTotalPayment($dayDifference, $room->price) + ($adult_num * 7 * $dayDifference) +  (($adult_num + $kids_num) * 8) )) + ($adult_num * 7 * $dayDifference) + (($adult_num + $kids_num) * 8 ) +(Helper::getTotalPayment($dayDifference, $room->price))}} "
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="minimum_dp" class="col-sm-2 col-form-label">Minimum DP</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="minimum_dp" name="minimum_dp"
                                                placeholder="col-form-label"
                                                value="{{ Helper::convertToRupiah($downPayment) }} " readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="downPayment" class="col-sm-2 col-form-label">Payment</label>
                                        <div class="col-sm-10">
                                            <input type="text"
                                                class="form-control @error('downPayment') is-invalid @enderror"
                                                id="downPayment" name="downPayment" placeholder="Input payment here"
                                                value="{{ old('downPayment') }}">
                                            @error('downPayment')
                                                <div class="text-danger mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10" id="showPaymentType"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-end">Pay DownPayment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="card shadow-sm">
                    <img src="{{ $customer->user->getAvatar() }}"
                        style="border-top-right-radius: 0.5rem; border-top-left-radius: 0.5rem">
                    <div class="card-body">
                        <table>
                            <tr>
                                <td style="text-align: center; width:50px">
                                    <span>
                                        <i class="fas {{ $customer->gender == 'Male' ? 'fa-male' : 'fa-female' }}">
                                        </i>
                                    </span>
                                </td>
                                <td>
                                    {{ $customer->name }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; ">
                                    <span>
                                        <i class="fas fa-user-md"></i>
                                    </span>
                                </td>
                                <td>{{ $customer->job }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; ">
                                    <span>
                                        <i class="fas fa-birthday-cake"></i>
                                    </span>
                                </td>
                                <td>
                                    {{ $customer->birthdate }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; ">
                                    <span>
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                </td>
                                <td>
                                    {{ $customer->address }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script src="{{ asset('style/js/jquery.js') }}"></script>
<script>
    $('#downPayment').keyup(function() {
        $('#showPaymentType').text('DH. ' + parseFloat($(this).val(), 10).toFixed(2).replace(
                /(\d)(?=(\d{3})+\.)/g, "$1.")
            .toString());
    });

</script>
@endsection
