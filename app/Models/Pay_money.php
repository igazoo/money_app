<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Pay_money extends Model
{
    //
    public function now_month_sum()
    {
        $now_date = Carbon::now();
        $now_month = $now_date->month;
        $user_id = Auth::id();
        $all = Pay_money::where('user_id', $user_id)->get();
        $now = [];

        foreach ($all as $pay) {
            $d = $pay->date;
            $m = strtotime($d);
            $month = idate('m', $m);
            if ($month === $now_month) {
                $now[] = $pay->money;
            }
        }
        $sum = array_sum($now); //今月
        return $sum;
    }

    public function last_month_sum()
    {
        $now_date = Carbon::now();
        $now_month = $now_date->month;
        $user_id = Auth::id();
        $all = Pay_money::where('user_id', $user_id)->get();
        $now_1 = []; //先月

        $back_date = $now_date->month - 1;
        foreach ($all as $pay) {
            $d = $pay->date;
            $m = strtotime($d);
            $month = idate('m', $m);
            if ($month === $back_date) {
                $now_1[] = $pay->money;
            }
        }
        $sum_1 = array_sum($now_1); //先月
        return $sum_1;
    }

    public function last_month_2_sum()
    {
        $now_date = Carbon::now();
        $now_month = $now_date->month;
        $user_id = Auth::id();
        $all = Pay_money::where('user_id', $user_id)->get();

        $now_2 = []; //先々月

        $back_date_2 = $now_date->month - 2;
        foreach ($all as $pay) {
            $d = $pay->date;
            $m = strtotime($d);
            $month = idate('m', $m);
            if ($month === $back_date_2) {
                $now_2[] = $pay->money;
            }
        }
        $sum_2 = array_sum($now_2); //先々月
        return $sum_2;
    }
}
