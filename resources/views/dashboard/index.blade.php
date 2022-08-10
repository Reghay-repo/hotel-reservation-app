@extends('template.master')
@section('title', 'Dashboard')
@section('head')
    {{-- <link rel="stylesheet" href="{{ asset('style/css/admin.css') }}"> --}}
@endsection
@section('content')
    <div id="dashboard">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border" style="border-radius: 0.5rem">
                            <div class="card-body">
                                <h5>{{ count($transactions) }} Guests this day</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm border" style="border-radius: 0.5rem">
                            <div class="card-body text-center">
                                <h5>Dashboard</h5>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box border -->
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border">
                            <div class="card-header">
                                <div class="row ">
                                    <div class="col-lg-12 d-flex justify-content-between">
                                        <h3>Today Guests</h3>
                                        <div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Room</th>
                                            <th class="text-center">Stay</th>
                                            <th>Day Left</th>
                                            <th>Debt</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($transactions as $transaction)
                                            <tr>
                                                <td>
                                                    <img src="{{ $transaction->customer->user->getAvatar() }}"
                                                        class="rounded-circle img-thumbnail" width="40" height="40" alt="">
                                                </td>
                                                <td>
                                                    <a href="{{route('customer.show',['customer'=>$transaction->customer->id])}}">
                                                        {{ $transaction->customer->name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{route('room.show', ['room'=>$transaction->room->id])}}">
                                                        {{ $transaction->room->number }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ Helper::dateFormat($transaction->check_in) }} ~
                                                    {{ Helper::dateFormat($transaction->check_out) }}
                                                </td>
                                                <td>{{ Helper::getDateDifference(now(), $transaction->check_out) == 0 ? 'Last Day' :  Helper::getDateDifference(now(), $transaction->check_out). ' '. Helper::plural('Day', Helper::getDateDifference(now(), $transaction->check_out))}}
                                                </td>
                                                <td>
                                                    {{ $transaction->getTotalPrice() - $transaction->getTotalPayment() <= 0 ? '-' : Helper::convertToRupiah($transaction->getTotalPrice() - $transaction->getTotalPayment()) }}
                                                </td>
                                                <td>
                                                  
                                                    <span
                                                        class="justify-content-center badge {{ $transaction->getTTTC() - $transaction->getTotalPayment() == 0 ? 'bg-success' : 'bg-warning' }}">
                                                        {{ $transaction->getTTTC() - $transaction->getTotalPayment() == 0 ? 'Success' : 'Progress' }}
                                                    </span>
                                                    @if (Helper::getDateDifference(now(), $transaction->check_out) < 1)
                                                        <span class="justify-content-center badge bg-danger">
                                                            must finish payment
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    There's no data in this table
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Monthly Guests Chart</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <p class="d-flex flex-column">
                                        {{-- <span class="text-bold text-lg">Belum</span> --}}
                                        {{-- <span>Total Guests at {{ Helper::thisMonth() . '/' . Helper::thisYear() }}</span> --}}
                                    </p>
                                    {{-- <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> Belum
                                    </span>
                                    <span class="text-muted">Since last month</span>
                                </p> --}}
                                </div>
                                <div class="position-relative mb-4">
                                    <canvas this-year="{{ Helper::thisYear() }}"
                                        this-month="{{ Helper::thisMonth() }}" id="visitors-chart" height="400"
                                        width="100%" class="chartjs-render-monitor"
                                        style="display: block; width: 249px; height: 200px;"></canvas>
                                </div>
                                <div class="d-flex flex-row justify-content-between">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> {{ Helper::thisMonth() }}
                                    </span>
                                    <span>
                                        <i class="fas fa-square text-gray"></i> Last month
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h1>Monthly results</h1>
                <div class="form-group mx-sm-3 mb-2">
                    <form action="{{ route('dashboard.index') }}" class="form-inline"  method="GET">
                                @csrf
                            <div>
                                <label for="year" >Year :</label>
                                <input type="text" name="year" class="form-control" placeholder="i.e:2022" id="year" value="{{ request()->input('year') }}">
                            </div>
                            {{-- @dd($months) --}}
                            <div>
                                <button class="btn btn-primary my-2">update</button>
                            </div>
                        </div>
                    </form>
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">N de pax</th>
                        <th scope="col">N. des adults</th>
                        <th scope="col">N. des enfants</th>
                        <th scope="col">Total HT</th>
                        <th scope="col">TPT</th>
                        <th scope="col">TS</th>
                        <th scope="col">TVA</th>
                        <th scope="col">TOTAL TTC</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">janvier</th>
                        <td>{{ $months['01']['number_of_people'] }}</td>
                        <td>{{ $months['01']['number_of_adults'] }}</td>
                        <td>{{ $months['01']['number_of_kids'] }}</td>
                        <td>{{ $months['01']['total_ht'] }}</td>
                        <td>{{ $months['01']['tpt'] }}</td>
                        <td>{{ $months['01']['ts'] }}</td>
                        <td>{{ $months['01']['tva'] }}</td>
                        <td>{{ $months['01']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">fèvrier</th>
                        <td>{{ $months['02']['number_of_people'] }}</td>
                        <td>{{ $months['02']['number_of_adults'] }}</td>
                        <td>{{ $months['02']['number_of_kids'] }}</td>
                        <td>{{ $months['02']['total_ht'] }}</td>
                        <td>{{ $months['02']['tpt'] }}</td>
                        <td>{{ $months['02']['ts'] }}</td>
                        <td>{{ $months['02']['tva'] }}</td>
                        <td>{{ $months['02']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">mars</th>
                        <td>{{ $months['03']['number_of_people'] }}</td>
                        <td>{{ $months['03']['number_of_adults'] }}</td>
                        <td>{{ $months['03']['number_of_kids'] }}</td>
                        <td>{{ $months['03']['total_ht'] }}</td>
                        <td>{{ $months['03']['tpt'] }}</td>
                        <td>{{ $months['03']['ts'] }}</td>
                        <td>{{ $months['03']['tva'] }}</td>
                        <td>{{ $months['03']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">avril</th>
                        <td>{{ $months['04']['number_of_people'] }}</td>
                        <td>{{ $months['04']['number_of_adults'] }}</td>
                        <td>{{ $months['04']['number_of_kids'] }}</td>
                        <td>{{ $months['04']['total_ht'] }}</td>
                        <td>{{ $months['04']['tpt'] }}</td>
                        <td>{{ $months['04']['ts'] }}</td>
                        <td>{{ $months['04']['tva'] }}</td>
                        <td>{{ $months['04']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">mai</th>
                        <td>{{ $months['05']['number_of_people'] }}</td>
                        <td>{{ $months['05']['number_of_adults'] }}</td>
                        <td>{{ $months['05']['number_of_kids'] }}</td>
                        <td>{{ $months['05']['total_ht'] }}</td>
                        <td>{{ $months['05']['tpt'] }}</td>
                        <td>{{ $months['05']['ts'] }}</td>
                        <td>{{ $months['05']['tva'] }}</td>
                        <td>{{ $months['05']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">juin</th>
                        <td>{{ $months['06']['number_of_people'] }}</td>
                        <td>{{ $months['06']['number_of_adults'] }}</td>
                        <td>{{ $months['06']['number_of_kids'] }}</td>
                        <td>{{ $months['06']['total_ht'] }}</td>
                        <td>{{ $months['06']['tpt'] }}</td>
                        <td>{{ $months['06']['ts'] }}</td>
                        <td>{{ $months['06']['tva'] }}</td>
                        <td>{{ $months['06']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">juillet</th>
                        <td>{{ $months['07']['number_of_people'] }}</td>
                        <td>{{ $months['07']['number_of_adults'] }}</td>
                        <td>{{ $months['07']['number_of_kids'] }}</td>
                        <td>{{ $months['07']['total_ht'] }}</td>
                        <td>{{ $months['07']['tpt'] }}</td>
                        <td>{{ $months['07']['ts'] }}</td>
                        <td>{{ $months['07']['tva'] }}</td>
                        <td>{{ $months['07']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">aout</th>
                        <td>{{ $months['08']['number_of_people'] }}</td>
                        <td>{{ $months['08']['number_of_adults'] }}</td>
                        <td>{{ $months['08']['number_of_kids'] }}</td>
                        <td>{{ $months['08']['total_ht'] }}</td>
                        <td>{{ $months['08']['tpt'] }}</td>
                        <td>{{ $months['08']['ts'] }}</td>
                        <td>{{ $months['08']['tva'] }}</td>
                        <td>{{ $months['08']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">septembre</th>
                        <td>{{ $months['09']['number_of_people'] }}</td>
                        <td>{{ $months['09']['number_of_adults'] }}</td>
                        <td>{{ $months['09']['number_of_kids'] }}</td>
                        <td>{{ $months['09']['total_ht'] }}</td>
                        <td>{{ $months['09']['tpt'] }}</td>
                        <td>{{ $months['09']['ts'] }}</td>
                        <td>{{ $months['09']['tva'] }}</td>
                        <td>{{ $months['09']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">octobre</th>
                        <td>{{ $months['10']['number_of_people'] }}</td>
                        <td>{{ $months['10']['number_of_adults'] }}</td>
                        <td>{{ $months['10']['number_of_kids'] }}</td>
                        <td>{{ $months['10']['total_ht'] }}</td>
                        <td>{{ $months['10']['tpt'] }}</td>
                        <td>{{ $months['10']['ts'] }}</td>
                        <td>{{ $months['10']['tva'] }}</td>
                        <td>{{ $months['10']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">novembre</th>
                        <td>{{ $months['11']['number_of_people'] }}</td>
                        <td>{{ $months['11']['number_of_adults'] }}</td>
                        <td>{{ $months['11']['number_of_kids'] }}</td>
                        <td>{{ $months['11']['total_ht'] }}</td>
                        <td>{{ $months['11']['tpt'] }}</td>
                        <td>{{ $months['11']['ts'] }}</td>
                        <td>{{ $months['11']['tva'] }}</td>
                        <td>{{ $months['11']['total_ttc'] }}</td>
                      </tr>
                      <tr>
                        <th scope="row">decembre</th>
                        <td>{{ $months['12']['number_of_people'] }}</td>
                        <td>{{ $months['12']['number_of_adults'] }}</td>
                        <td>{{ $months['12']['number_of_kids'] }}</td>
                        <td>{{ $months['12']['total_ht'] }}</td>
                        <td>{{ $months['12']['tpt'] }}</td>
                        <td>{{ $months['12']['ts'] }}</td>
                        <td>{{ $months['12']['tva'] }}</td>
                        <td>{{ $months['12']['total_ttc'] }}</td>
                      </tr>
                    </tbody>
                  </table>    
            </div>
            <div class="col-md-6">
                {{-- tri monthly table --}}
               <div class="row">
                <div class="row">
                    <h1>Periodic Monthly results</h1>
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">N de pax</th>
                        <th scope="col">N. des adults</th>
                        <th scope="col">N. des enfants</th>
                        <th scope="col">Total HT</th>
                        <th scope="col">TPT</th>
                        <th scope="col">TS</th>
                        <th scope="col">TVA</th>
                        <th scope="col">TOTAL TTC</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">Tri 1</th>
                        <td>{{ $months['01']['number_of_people'] + $months['02']['number_of_people'] +$months['03']['number_of_people'] }}</td>
                        <td>{{ $months['01']['number_of_adults'] +$months['02']['number_of_adults']  + $months['03']['number_of_adults']  }}</td>
                        <td>{{ $months['01']['number_of_kids']+ $months['02']['number_of_kids'] + $months['03']['number_of_kids'] }}</td>
                        <td>{{ $months['01']['total_ht'] + $months['02']['total_ht'] + $months['03']['total_ht'] }}</td>
                        <td>{{ $months['01']['tpt']  + $months['02']['tpt']  + $months['03']['tpt'] }}</td>
                        <td>{{ $months['01']['ts'] +  $months['02']['ts']  + $months['03']['ts']  }}</td>
                        <td>{{ $months['01']['tva'] +$months['02']['tva'] +$months['03']['tva'] }}</td>
                        <td>{{ $months['01']['total_ttc'] + $months['02']['total_ttc']  + $months['03']['total_ttc']  }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Tri 2</th>
                        <td>{{ $months['04']['number_of_people'] + $months['05']['number_of_people'] +$months['06']['number_of_people'] }}</td>
                        <td>{{ $months['04']['number_of_adults'] +$months['05']['number_of_adults']  + $months['06']['number_of_adults']  }}</td>
                        <td>{{ $months['04']['number_of_kids'] +$months['05']['number_of_kids'] + $months['06']['number_of_kids'] }}</td>
                        <td>{{ $months['04']['total_ht'] + $months['05']['total_ht'] + $months['06']['total_ht'] }}</td>
                        <td>{{ $months['04']['tpt']  + $months['05']['tpt']  + $months['06']['tpt'] }}</td>
                        <td>{{ $months['04']['ts'] +  $months['05']['ts']  + $months['06']['ts']  }}</td>
                        <td>{{ $months['04']['tva'] +$months['05']['tva'] +$months['06']['tva'] }}</td>
                        <td>{{ $months['04']['total_ttc'] + $months['05']['total_ttc']  + $months['06']['total_ttc']  }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Tri 3</th>
                        <td>{{ $months['07']['number_of_people'] + $months['08']['number_of_people'] +$months['09']['number_of_people'] }}</td>
                        <td>{{ $months['07']['number_of_adults'] +$months['08']['number_of_adults']  + $months['09']['number_of_adults']  }}</td>
                        <td>{{ $months['07']['number_of_kids']+ $months['08']['number_of_kids'] + $months['09']['number_of_kids'] }}</td>
                        <td>{{ $months['07']['total_ht'] + $months['08']['total_ht'] + $months['09']['total_ht'] }}</td>
                        <td>{{ $months['07']['tpt']  + $months['08']['tpt']  + $months['09']['tpt'] }}</td>
                        <td>{{ $months['07']['ts'] +  $months['08']['ts']  + $months['09']['ts']  }}</td>
                        <td>{{ $months['07']['tva'] +$months['08']['tva'] +$months['09']['tva'] }}</td>
                        <td>{{ $months['07']['total_ttc'] + $months['08']['total_ttc']  + $months['09']['total_ttc']  }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Tri 4</th>
                        <td>{{ $months['10']['number_of_people'] + $months['11']['number_of_people'] +$months['12']['number_of_people'] }}</td>
                        <td>{{ $months['10']['number_of_adults'] +$months['11']['number_of_adults']  + $months['12']['number_of_adults']  }}</td>
                        <td>{{ $months['10']['number_of_kids']+ $months['11']['number_of_kids'] + $months['12']['number_of_kids'] }}</td>
                        <td>{{ $months['10']['total_ht'] + $months['11']['total_ht'] + $months['12']['total_ht'] }}</td>
                        <td>{{ $months['10']['tpt']  + $months['11']['tpt']  + $months['12']['tpt'] }}</td>
                        <td>{{ $months['10']['ts'] +  $months['11']['ts']  + $months['12']['ts']  }}</td>
                        <td>{{ $months['10']['tva'] +$months['11']['tva'] +$months['12']['tva'] }}</td>
                        <td>{{ $months['10']['total_ttc'] + $months['11']['total_ttc']  + $months['12']['total_ttc']  }}</td>
                      </tr>
                     
                    </tbody>
                  </table> 
                </div> 
                    <div class="row">
                        <div class="col-md-12">
                            <h1>yearly results</h1>
                            <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">N de pax</th>
                                    <th scope="col">N. des adults</th>
                                    <th scope="col">N. des enfants</th>
                                    <th scope="col">Total HT</th>
                                    <th scope="col">TPT</th>
                                    <th scope="col">TS</th>
                                    <th scope="col">TVA</th>
                                    <th scope="col">TOTAL TTC</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th scope="row">{{ $year }}</th>
                                    <td>{{ $months['01']['number_of_people'] + $months['02']['number_of_people'] +$months['03']['number_of_people'] +$months['04']['number_of_people'] + $months['05']['number_of_people'] + $months['06']['number_of_people'] + $months['07']['number_of_people'] + $months['08']['number_of_people'] + $months['09']['number_of_people'] + $months['10']['number_of_people'] + $months['11']['number_of_people'] + $months['12']['number_of_people']         }}</td>
                                    <td>{{ $months['01']['number_of_adults'] + $months['02']['number_of_adults'] +$months['03']['number_of_adults'] +$months['04']['number_of_adults'] + $months['05']['number_of_adults'] + $months['06']['number_of_adults'] + $months['07']['number_of_adults'] + $months['08']['number_of_adults'] + $months['09']['number_of_adults'] + $months['10']['number_of_adults'] + $months['11']['number_of_adults'] + $months['12']['number_of_adults']         }}</td>
                                    <td>{{ $months['01']['number_of_kids'] + $months['02']['number_of_kids'] +$months['03']['number_of_kids'] +$months['04']['number_of_kids'] + $months['05']['number_of_kids'] + $months['06']['number_of_kids'] + $months['07']['number_of_kids'] + $months['08']['number_of_kids'] + $months['09']['number_of_kids'] + $months['10']['number_of_kids'] + $months['11']['number_of_kids'] + $months['12']['number_of_kids']         }}</td>
                                    <td>{{ $months['01']['total_ht'] + $months['02']['total_ht'] +$months['03']['total_ht'] +$months['04']['total_ht'] + $months['05']['total_ht'] + $months['06']['total_ht'] + $months['07']['total_ht'] + $months['08']['total_ht'] + $months['09']['total_ht'] + $months['10']['total_ht'] + $months['11']['total_ht'] + $months['12']['total_ht']         }}</td>
                                    <td>{{ $months['01']['tpt'] + $months['02']['tpt'] +$months['03']['tpt'] +$months['04']['tpt'] + $months['05']['tpt'] + $months['06']['tpt'] + $months['07']['tpt'] + $months['08']['tpt'] + $months['09']['tpt'] + $months['10']['tpt'] + $months['11']['tpt'] + $months['12']['tpt']         }}</td>
                                    <td>{{ $months['01']['ts'] + $months['02']['ts'] +$months['03']['ts'] +$months['04']['ts'] + $months['05']['ts'] + $months['06']['ts'] + $months['07']['ts'] + $months['08']['ts'] + $months['09']['ts'] + $months['10']['ts'] + $months['11']['ts'] + $months['12']['ts']         }}</td>
                                    <td>{{ $months['01']['tva'] + $months['02']['tva'] +$months['03']['tva'] +$months['04']['tva'] + $months['05']['tva'] + $months['06']['tva'] + $months['07']['tva'] + $months['08']['tva'] + $months['09']['tva'] + $months['10']['tva'] + $months['11']['tva'] + $months['12']['tva']         }}</td>
                                    <td>{{ $months['01']['total_ttc'] + $months['02']['total_ttc'] +$months['03']['total_ttc'] +$months['04']['total_ttc'] + $months['05']['total_ttc'] + $months['06']['total_ttc'] + $months['07']['total_ttc'] + $months['08']['total_ttc'] + $months['09']['total_ttc'] + $months['10']['total_ttc'] + $months['11']['total_ttc'] + $months['12']['total_ttc']         }}</td>
                                  </tr>
                                  <tr>
                                   
                                 
                                </tbody>
                              </table>    
                        </div>
                    </div>  
               </div>
            </div>
        </div>
        <div class="row">
            {{-- year table --}}
           
        </div>
    </div>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script> --}}
    {{-- <canvas id="pieChart"></canvas> --}}
@endsection
@section('footer')
<script src="{{ asset('style/js/jquery.js') }}"></script>
<script src="{{ asset('style/js/chart.min.js') }}"></script>
<script src="{{ asset('style/js/guestsChart.js') }}"></script>
<script>
    function reloadJs(src) {
        src = $('script[src$="' + src + '"]').attr("src");
        $('script[src$="' + src + '"]').remove();
        $('<script/>').attr('src', src).appendTo('head');
    }

    Echo.channel('dashboard')
        .listen('.dashboard.event', (e) => {
            $("#dashboard").hide()
            $("#dashboard").load(window.location.href + " #dashboard");
            $("#dashboard").show(150)
            reloadJs('style/js/guestsChart.js');
            toastr.warning(e.message, "Hello, {{auth()->user()->name}}");
        })

</script>
@endsection
