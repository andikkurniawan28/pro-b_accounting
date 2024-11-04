@extends('template.master')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="row">
        <!-- Card for Total Revenue -->
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card border-left-primary shadow h-100 py-2" id="revenueCard">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Revenue {{ date('F') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalRevenue"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Total Expenses -->
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card border-left-success shadow h-100 py-2" id="expenseCard">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Expenses {{ date('F') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalExpenses"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Total COGS -->
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2" id="cogsCard">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total COGS {{ date('F') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalCOGS"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-industry fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card for Net Profit -->
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card border-left-warning shadow h-100 py-2" id="profitCard">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Net Profit {{ date('F') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="netProfit"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart for Cash Flow -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Cash Flow Chart in {{ date('Y') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="cashFlowChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue vs Expenses Chart in {{ date('Y') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="revenueExpensesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch data from the server
            $.ajax({
                url: "{{ route('income_statement.data', ['year' => date('Y'), 'month' => date('m')]) }}",
                method: "GET",
                success: function(data) {
                    // Update the dashboard cards with fetched data
                    $('#totalRevenue').text(data.totals.all_revenue);
                    $('#totalExpenses').text(data.totals.all_expense);
                    $('#totalCOGS').text(data.totals.cogs);
                    $('#netProfit').text(data.totals.net_profit);
                },
                error: function() {
                    alert('Failed to fetch data.');
                }
            });
        });
    </script>
    <script>
        var ctx1 = document.getElementById('cashFlowChart').getContext('2d');
        var cashFlowChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Cash Inflow',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    data: [
                        @for ($month = 1; $month <= 12; $month++)
                            {{ $data['cash_flow']['cash_inflow'][$month-1] }},
                        @endfor
                    ],
                }, {
                    label: 'Cash Outflow',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    data: [
                        @for ($month = 1; $month <= 12; $month++)
                            {{ $data['cash_flow']['cash_outflow'][$month-1] }},
                        @endfor
                    ],
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('revenueExpensesChart').getContext('2d');
        var revenueExpensesChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Total Revenue',
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    data: [
                        @for ($month = 1; $month <= 12; $month++)
                            {{ $data['revenue_vs_expenses']['revenue'][$month-1] }},
                        @endfor
                    ],
                }, {
                    label: 'Total Expenses',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    data: [
                        @for ($month = 1; $month <= 12; $month++)
                            {{ $data['revenue_vs_expenses']['expenses'][$month-1] }},
                        @endfor
                    ],
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
