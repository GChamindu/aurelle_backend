<?php $page = 'index_admin'; ?>
@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12 d-flex widget-path widget-service">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-userhead">
                                    <div class="home-usercount">
                                        <span><img src="{{ URL::asset('admin_assets/img/icons/user.svg') }}"
                                                alt="img"></span>
                                        <h6>Sales</h6>
                                    </div>
                                    <div class="home-useraction">
                                        <a class="delete-table bg-white" href="javascript:void(0);"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu" data-popper-placement="bottom-end">
                                            <li>
                                                <a href="{{ url('admin/users') }}" class="dropdown-item"> View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item"> Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="home-usercontent">
                                    <div class="home-usercontents">
                                        <div class="home-usercontentcount">
                                            <img src="{{ URL::asset('admin_assets/img/icons/arrow-up.svg') }}"
                                                alt="img" class="me-2">
                                            <span class="counters" data-count="30">30</span>
                                        </div>
                                        <h5> Current Month</h5>
                                    </div>
                                    <div class="homegraph">
                                        <img src="{{ URL::asset('admin_assets/img/graph/graph1.png') }}" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-sm-6 col-12 d-flex widget-path widget-service">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user home-provider">
                                <div class="home-userhead">
                                    <div class="home-usercount">
                                        <span><img src="{{ URL::asset('admin_assets/img/icons/user-circle.svg') }}"
                                                alt="img"></span>
                                        <h6>Providers</h6>
                                    </div>
                                    <div class="home-useraction">
                                        <a class="delete-table bg-white" href="javascript:void(0);"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu" data-popper-placement="bottom-end">
                                            <li>
                                                <a href="{{ url('admin/providers') }}" class="dropdown-item"> View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item"> Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="home-usercontent">
                                    <div class="home-usercontents">
                                        <div class="home-usercontentcount">
                                            <img src="{{ URL::asset('admin_assets/img/icons/arrow-up.svg') }}"
                                                alt="img" class="me-2">
                                            <span class="counters" data-count="25">25</span>
                                        </div>
                                        <h5> Current Month</h5>
                                    </div>
                                    <div class="homegraph">
                                        <img src="{{ URL::asset('admin_assets/img/graph/graph2.png') }}" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex widget-path widget-service">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user home-service">
                                <div class="home-userhead">
                                    <div class="home-usercount">
                                        <span><img src="{{ URL::asset('admin_assets/img/icons/service.svg') }}"
                                                alt="img"></span>
                                        <h6>Service</h6>
                                    </div>
                                    <div class="home-useraction">
                                        <a class="delete-table bg-white" href="javascript:void(0);"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu" data-popper-placement="bottom-end">
                                            <li>
                                                <a href="{{ url('admin/services') }}" class="dropdown-item"> View</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('admin/edit-service') }}" class="dropdown-item"> Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="home-usercontent">
                                    <div class="home-usercontents">
                                        <div class="home-usercontentcount">
                                            <img src="{{ URL::asset('admin_assets/img/icons/arrow-up.svg') }}"
                                                alt="img" class="me-2">
                                            <span class="counters" data-count="18">18</span>
                                        </div>
                                        <h5> Current Month</h5>
                                    </div>
                                    <div class="homegraph">
                                        <img src="{{ URL::asset('admin_assets/img/graph/graph3.png') }}" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex widget-path widget-service">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user home-subscription">
                                <div class="home-userhead">
                                    <div class="home-usercount">
                                        <span><img src="{{ URL::asset('admin_assets/img/icons/money.svg') }}"
                                                alt="img"></span>
                                        <h6>Sales</h6>
                                    </div>
                                    <div class="home-useraction">
                                        <a class="delete-table bg-white" href="javascript:void(0);"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu" data-popper-placement="bottom-end">
                                            <li>
                                                <a href="{{ url('admin/membership') }}" class="dropdown-item"> View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item"> Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="home-usercontent">
                                    <div class="home-usercontents">
                                        <div class="home-usercontentcount">
                                            <img src="{{ URL::asset('admin_assets/img/icons/arrow-up.svg') }}"
                                                alt="img" class="me-2">
                                            <span class="counters" data-count="650">$650</span>
                                        </div>
                                        <h5> Current Month</h5>
                                    </div>
                                    <div class="homegraph">
                                        <img src="{{ URL::asset('admin_assets/img/graph/graph4.png') }}" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>


            {{-- <div class="row">
                <div class="col-lg-6 col-sm-6 col-12 d-flex  widget-path">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-head-user">
                                    <h2>Revenue</h2>
                                    <div class="home-select">
                                        <div class="dropdown">
                                            <button class="btn btn-action btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Monthly
                                            </button>
                                            <ul class="dropdown-menu" data-popper-placement="bottom-end">
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Weekly</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Monthly</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Yearly</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="dropdown">
                                            <a class="delete-table bg-white" href="javascript:void(0);"
                                                data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu" data-popper-placement="bottom-end">
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"> View</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"> Edit</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="chartgraph">
                                    <div id="chart-view"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12 d-flex  widget-path">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-head-user">
                                    <h2>Order Summary</h2>
                                    <div class="home-select">
                                        <div class="dropdown">
                                            <button class="btn btn-action btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Monthly
                                            </button>
                                            <ul class="dropdown-menu" data-popper-placement="bottom-end">
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Weekly</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Monthly</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Yearly</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="dropdown">
                                            <a class="delete-table bg-white" href="javascript:void(0);"
                                                data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu" data-popper-placement="bottom-end">
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"> View</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"> Edit</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="chartgraph">
                                    <div id="chart-booking"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12 d-flex widget-path">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-head-user home-graph-header">
                                    <h2>Top Services</h2>
                                    <a href="{{ url('admin/services') }}" class="btn btn-viewall">View All<img
                                            src="{{ URL::asset('admin_assets/img/icons/arrow-right.svg') }}"
                                            class="ms-2" alt="img"></a>
                                </div>
                                <div class="table-responsive datatable-nofooter">
                                    <table class="table datatable" id="index-data">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Service</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 d-flex widget-path">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-head-user home-graph-header">
                                    <h2>Top Providers</h2>
                                    <a href="{{ url('admin/providers') }}" class="btn btn-viewall">View All<img
                                            src="{{ URL::asset('admin_assets/img/icons/arrow-right.svg') }}"
                                            class="ms-2" alt="img"></a>
                                </div>
                                <div class="table-responsive datatable-nofooter">
                                    <table class="table datatable " id="index-provider-data">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Provider Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-sm-12 d-flex widget-path">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-head-user home-graph-header">
                                    <h2>Top Countries</h2>
                                    <div class="home-select">
                                        <div class="dropdown">
                                            <button class="btn btn-action btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Monthly
                                            </button>
                                            <ul class="dropdown-menu" data-popper-placement="bottom-end">
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Weekly</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Monthly</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Yearly</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="dropdown">
                                            <a class="delete-table bg-white" href="javascript:void(0);"
                                                data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu" data-popper-placement="bottom-end">
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"> View</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"> Edit</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="chartgraph">
                                    <div class="row align-items-center">
                                        <div class="col-lg-7">
                                            <div id="world_map" style="height: 150px"></div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="bookingmap">
                                                <ul>
                                                    <li>
                                                        <span><img src="{{ URL::asset('admin_assets/img/flags/us.png') }}"
                                                                alt="img" class="me-2">United State</span>
                                                        <h6>60%</h6>
                                                    </li>
                                                    <li>
                                                        <span><img src="{{ URL::asset('admin_assets/img/flags/in.png') }}"
                                                                alt="img" class="me-2">India</span>
                                                        <h6>80%</h6>
                                                    </li>
                                                    <li>
                                                        <span><img src="{{ URL::asset('admin_assets/img/flags/ca.png') }}"
                                                                alt="img" class="me-2">Canada</span>
                                                        <h6>50%</h6>
                                                    </li>
                                                    <li>
                                                        <span><img src="{{ URL::asset('admin_assets/img/flags/au.png') }}"
                                                                alt="img" class="me-2">Australia</span>
                                                        <h6>75%</h6>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 d-flex widget-path">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-head-user home-graph-header">
                                    <h2>Sales Statistics</h2>
                                    <a href="{{ url('admin/booking') }}" class="btn btn-viewall">View All<img
                                            src="{{ URL::asset('admin_assets/img/icons/arrow-right.svg') }}"
                                            class="ms-2" alt="img"></a>
                                </div>
                                <div class="chartgraph">
                                    <div class="row align-items-center">
                                        <div class="col-lg-7 col-sm-6">
                                            <div id="chart-bar"></div>
                                        </div>
                                        <div class="col-lg-5 col-sm-6">
                                            <div class="bookingstatus">
                                                <ul>
                                                    <li>
                                                        <span></span>
                                                        <h6>Completed</h6>
                                                    </li>
                                                    <li class="process-status">
                                                        <span></span>
                                                        <h6>Process</h6>
                                                    </li>
                                                    <li class="process-pending">
                                                        <span></span>
                                                        <h6>Pending</h6>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


            {{-- <div class="row">
                <div class="col-lg-12 widget-path">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-head-user home-graph-header">
                                    <h2>Recent Booking</h2>
                                    <a href="{{ url('admin/booking') }}" class="btn btn-viewall">View All<img
                                            src="{{ URL::asset('admin_assets/img/icons/arrow-right.svg') }}"
                                            class="ms-2" alt="img"></a>
                                </div>
                                <div class="table-responsive datatable-nofooter">
                                    <table class="table datatable" id="index-booking-data">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Order Time</th>
                                                <th>Provider</th>
                                                <th>User</th>
                                                <th>Service</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


        </div>
    </div>
@endsection
