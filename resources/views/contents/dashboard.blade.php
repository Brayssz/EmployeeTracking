@extends('layouts.app-layout')

@section('content')
    <div class="container py-5">
        <h4 class="mb-4">Dashboard</h4>
        <div class="row g-3">

            <!-- Card 1 -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title">Total Present</h6>
                        <h2 class="card-text">{{$present}}</h2>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('daily-attendance') }}" class="btn btn-primary w-100">VIEW DETAILS</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title">Absent</h6>
                        <h2 class="card-text">{{$absent}}</h2>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('daily-attendance') }}" class="btn btn-primary w-100">VIEW DETAILS</a>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title">On-Travels</h6>
                        <h2 class="card-text">{{$ontravel}}</h2>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <button class="btn btn-primary w-100">VIEW DETAILS</button>
                    </div>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-md-3 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title"> On-Leave</h6>
                        <h2 class="card-text">{{$onleave}}</h2>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <button class="btn btn-primary w-100">VIEW DETAILS</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
