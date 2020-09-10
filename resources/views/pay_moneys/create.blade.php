@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('支出記録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pay_moneys.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('金額') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control r" name="money" autocomplete="off">
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="datepicker" class="col-md-4 col-form-label text-md-right">日付</label>
                            <div class="col-md-6" id="date_picker">
                                <Datepicker v-model="defaultDate" :format="DatePickerFormat" :language="ja" name="date">
                                </Datepicker>
                            </div>
                        </div>
                        <div class="form-group row">
                            <select name="category_id">
                                <option value="" hidden disabled selected></option>
                                @foreach($categories as $category)
                                <option value={{$category->id}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="income_money_create_btn ">
                            <button type="submit" class="btn btn-primary" id="income_money_btn">
                                {{ __('記録する') }}
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection