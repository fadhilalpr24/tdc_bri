@extends('layouts.front')

@section('title')
    <title>Brisol Monthly Target</title>
@endsection

@section('content')
    <div class="p-10 mx-auto my-10 rounded-lg shadow-lg">
        <h1 class="mb-4 text-2xl font-semibold sm:text-3xl">Brisol Monthly Target</h1>
        <div class="flex items-center justify-between gap-3">
            <div class="w-1/3">
            </div>
            <div class="w-1/2 mx-auto text-center">
                <select id="chartDropdownSelector" class="w-full px-4 py-4 text-xl text-white border rounded cursor-pointer bg-dark-blue focus:outline-none focus:border-blue-900 focus:shadow-outline-blue">
                    <option value="{{ route('brisol.monthly-target') }}">Brisol Monthly Target</option>
                    <option value="{{ route('brisol.reported-source') }}">Brisol Reported Source</option>
                    <option value="{{ route('brisol.service-ci-top-issue') }}">Brisol Service CI Top Issue</option>
                    <option value="{{ route('brisol.slm-status') }}">Brisol SLM Status</option>
                    <option value="{{ route('brisol.service-ci') }}">Brisol Service CI</option>
                </select>
            </div>
            <div class="w-1/3">
                <div class="flex items-end justify-end gap-4">
                        <select name="year" id="yearFilter">
                            @foreach(range(2020, date('Y')) as $year)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                </div>
            </div>
        </div>
        <canvas id="monthlyDataChart" class="mt-6"></canvas>
    </div>
@endsection

@section('script')
<script>
    document.getElementById("chartDropdownSelector").addEventListener("change", function() {
        const selectedURL = this.value;
        if (selectedURL) {
            window.location.href = selectedURL;
        }
    });

    let myChart;

    const ctx = document.getElementById('monthlyDataChart').getContext('2d');

    function updateChart(data) {
        if (myChart) {
            myChart.destroy();
        }

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Target',
                    data: data.targets,
                    borderColor: '#EE1515',
                    borderDash: [5, 5],
                    fill: false
                },
                {
                    label: 'Actual',
                    data: data.actuals,
                    borderColor: '#2B4CDE',
                    fill: false
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
    }

    function fetchDataForYear(year) {
        fetch('/api/brisol/get-monthly-target-actual?year=' + year)
            .then(response => response.json())
            .then(data => {
                updateChart(data);
            });
    }

    document.getElementById('yearFilter').addEventListener('change', function() {
        let selectedYear = this.value;
        fetchDataForYear(selectedYear);
    });

    document.addEventListener('DOMContentLoaded', function() {
        let currentYear = new Date().getFullYear();
        document.getElementById('yearFilter').value = currentYear;
        fetchDataForYear(currentYear);
    });
</script>
@endsection
