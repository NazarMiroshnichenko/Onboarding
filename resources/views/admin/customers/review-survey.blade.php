@extends('spark::layouts.app')

@section('content')

  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.customer.show', $user)}}">{{$user->project_name}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$survey->survey_name}}</li>
      </ol>
    </nav>
  </div>

  <home :user="user" inline-template>
    <div class="container">
      <!-- Application Dashboard -->
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card card-default">
            <div class="card-header">
              <span class="card-title">
                {{$survey->survey_name}}
              </span>
              <div class="progress">
                <div class="progress-bar" style="width: {{$progress['progress']}}%;" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                  {{$progress['progress']}}%
                </div>
              </div>
            </div>
            <div class="card-body">

                @foreach($questions as $question)
                 @include('admin.customers._question-review-modal', compact('question'))
                @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
  </home>
@endsection