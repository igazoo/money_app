@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">

                    <div id="chart-div"></div>

                    @foreach($all_income as $v)

                    {!! $lava->render("ColumnChart", "IMDB", "chart-div") !!}
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection