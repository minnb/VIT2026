@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
  <div class="row">
    @foreach($stats as $stat)
      <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card-box noradius noborder {{ $stat['bg'] }}">
          <i class="fa {{ $stat['icon'] }} float-right text-white"></i>
          <h6 class="text-white text-uppercase m-b-20">{{ $stat['label'] }}</h6>
          <h1 class="m-b-20 text-white counter">{{ $stat['count'] }}</h1>
          <span class="text-white">{{ $stat['note'] }}</span>
        </div>
      </div>
    @endforeach
  </div>
@endsection
