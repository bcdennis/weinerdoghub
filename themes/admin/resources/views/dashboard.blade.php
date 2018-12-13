@extends('admin::app')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-danger pull-right">Total</span>
                                    <h5>Users</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ formatNumber($totalUsers) }}</h1>
                                    <small>Total Users</small>
                                    <a href="{{ route('admin.users') }}" class="text-danger pull-right">see</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-success pull-right">Total</span>
                                    <h5>Posts</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ formatNumber($totalPosts) }}</h1>
                                    <small>Total Posts</small>
                                    <a href="{{ route('admin.posts') }}" class="text-success pull-right">see</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-warning pull-right">Total</span>
                                    <h5>Reports</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ formatNumber($totalReports) }}</h1>
                                    <small>Total Reports</small>
                                    <a href="{{ route('admin.reports.posts') }}" class="text-warning pull-right">see</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-info pull-right">Total</span>
                                    <h5>Visits</h5>
                                </div>
                                <div class="ibox-content">
                                    <h1 class="no-margins">{{ formatNumber($totalVisits) }}</h1>
                                    <small>Total Visits</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                                    <div>
                                        <h3 class="font-bold no-margins">
                                            Half-year statistics
                                        </h3>
                                        <small>Visits</small>
                                    </div>

                                    <div class="m-t-sm">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <canvas id="lineChart" height="74"></canvas>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end of col-md-12 graph -->
                    </div>
                </div> <!-- end col-md-8 left-side -->

                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">This Month</span>
                            <h5>User activity</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-4">
                                    <small class="stats-label">Visits</small>
                                    <h4>{{ $visitsNow->value }}</h4>
                                </div>

                                <div class="col-xs-4">
                                    <small class="stats-label">Growth</small>
                                    <h4>{{ growthRate($visitsNow->value, $visitsThen->value) }}%</h4>
                                </div>
                                <div class="col-xs-4">
                                    <small class="stats-label">Last Month</small>
                                    <h4>{{ $visitsThen->value }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-4">
                                    <small class="stats-label">New Users</small>
                                    <h4>{{ $usersNow->value }}</h4>
                                </div>

                                <div class="col-xs-4">
                                    <small class="stats-label">Growth</small>
                                    <h4>{{ growthRate($usersNow->value, $usersThen->value) }}%</h4>
                                </div>
                                <div class="col-xs-4">
                                    <small class="stats-label">Last Month</small>
                                    <h4>{{ $usersThen->value }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-4">
                                    <small class="stats-label">New Posts</small>
                                    <h4>{{ $postsNow->value }}</h4>
                                </div>

                                <div class="col-xs-4">
                                    <small class="stats-label">Growth</small>
                                    <h4>{{ growthRate($postsNow->value, $postsThen->value) }}%</h4>
                                </div>
                                <div class="col-xs-4">
                                    <small class="stats-label">Last Month</small>
                                    <h4>{{ $postsThen->value }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-xs-4">
                                    <small class="stats-label">Reports</small>
                                    <h4>{{ $reportsNow->value }}</h4>
                                </div>

                                <div class="col-xs-4">
                                    <small class="stats-label">Growth</small>
                                    <h4>{{ growthRate($reportsNow->value, $reportsThen->value) }}%
                                </div>
                                <div class="col-xs-4">
                                    <small class="stats-label">Last Month</small>
                                    <h4>{{ $reportsThen->value }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end of col-md-4 right side -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of wrapper-content -->
@stop

@section('js')
 @parent
 <script>
     $(document).ready(function() {
         var lineData = {
             labels: {!!  chartMonths($chartData)  !!},
             datasets: [
                 {
                     label: "Example dataset",
                     fillColor: "rgba(204,24,30,0.3)",
                     strokeColor: "rgba(204,24,30,0.7)",
                     pointColor: "rgba(204,24,30,1)",
                     pointStrokeColor: "#fff",
                     pointHighlightFill: "#fff",
                     pointHighlightStroke: "rgba(204,24,30,1)",
                     data: {!!  chartData($chartData)  !!}
                 }
             ]
         };

         var lineOptions = {
             scaleShowGridLines: true,
             scaleGridLineColor: "rgba(0,0,0,.05)",
             scaleGridLineWidth: 1,
             bezierCurve: true,
             bezierCurveTension: 0.4,
             pointDot: true,
             pointDotRadius: 4,
             pointDotStrokeWidth: 1,
             pointHitDetectionRadius: 20,
             datasetStroke: true,
             datasetStrokeWidth: 2,
             datasetFill: true,
             responsive: true,
         };

         var ctx = document.getElementById("lineChart").getContext("2d");
         new Chart(ctx).Line(lineData, lineOptions);
     });
 </script>

@stop