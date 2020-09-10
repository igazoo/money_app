@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">

                    <div id="chart-div"></div>
                    @foreach($all_pay as $v)
                    @if($v->user_id === $user_id)
                    {!! $lava->render("ColumnChart", "IMDB", "chart-div") !!}
                    @else
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection