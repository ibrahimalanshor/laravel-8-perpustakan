@extends('__layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Books</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total['book'] }}</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-book fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Category</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total['category'] }}</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-tag fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Loan</div>
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $total['loan'] }}</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Active Loan</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total['activeLoan'] }}</div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header">
              <h6 class="m-0 font-weight-bold text-primary">Loan Overview</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-area">
                <canvas id="loanOverview"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header">
              <h6 class="m-0 font-weight-bold text-primary">Top Books</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-pie pt-4 pb-2">
                <canvas id="topBook"></canvas>
              </div>
              <div class="mt-4 text-center small book-label">
              </div>
            </div>
          </div>
        </div>
    </div>


@endsection

@push('scripts')

    <script src="{{ asset('sbadmin/vendor/chart.js/Chart.min.js') }}"></script>
    
    <script>
        const loanOverview = JSON.parse('{!! json_encode($loanOverview) !!}')
        const topBooks = JSON.parse('{!! json_encode($topBooks) !!}')
    </script>
    
    <script src="{{ asset('js/home.js') }}"></script>

@endpush