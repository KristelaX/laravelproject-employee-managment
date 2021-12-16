<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\User;
use App\Services\CalculateSalaryService as CalculateSalaryService;
use App\Departments;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\SalaryResult as SalaryResult;
use App\Services\Contracts\CalculateSalaryInterface as CalculateSalaryInterface;

define("KOEF_SIG_SHOQERORE_PUNONJESI" , 0.095);
define("KOEF_SIG_SHOQERORE_PUNEDHENESI" , 0.15);
define("KOEF_SIG_SHENDETESORE_PUNONJESI" , 0.017);
define("KOEF_TAP_1" , 0.13);
define("KOEF_TAP_2" , 0.23);
define("PAGA_TAP_1" , 30000);
define("PAGA_TAP_2" , 150000);

class CalculateSalaryService implements CalculateSalaryInterface
{
    public function calculateNettSalary($grossSalary)
    {
        if($grossSalary !=null)
        {
            $tap = $this->calculatePit($grossSalary);
            $sigurime_shoqerore_punonjesi = $this->calculateEmployeeSocialContribution($grossSalary);
            $sig_shendetesore_punonjesi = $sig_shendetesore_punedhenesi = $this->calculateHealthContribution($grossSalary);
            $sig_shoqerore_punedhenesi = $this->calculateEmployerSocialContribution($grossSalary);
            $paga_neto_per_tu_paguar = $grossSalary - $sigurime_shoqerore_punonjesi - $sig_shendetesore_punonjesi - $tap;
            return $paga_neto_per_tu_paguar;
        }
        else{
            throw new Exception("Ju lutem vendosni një vlerë");
        }
    }

    public function calculatePit($grossSalary)
    {
        if($grossSalary < PAGA_TAP_1)
        {
            $formula = 0;
        }
        else if($grossSalary < PAGA_TAP_2)
        {
            $formula = KOEF_TAP_2 * ($grossSalary - PAGA_TAP_1);
        }
        else
        {
            $formula = KOEF_TAP_2 * (PAGA_TAP_2 - PAGA_TAP_1) + KOEF_TAP_2 *($grossSalary - PAGA_TAP_2);
        }
        return $formula;
    }

    public function calculateEmployeeSocialContribution($grossSalary)
    {
        return $grossSalary * KOEF_SIG_SHOQERORE_PUNONJESI;
    }
    public function calculateEmployerSocialContribution($grossSalary)
    {
        return $grossSalary * KOEF_SIG_SHOQERORE_PUNEDHENESI;
    }
    public function calculateHealthContribution($grossSalary)
    {
        return $grossSalary * KOEF_SIG_SHENDETESORE_PUNONJESI;
    }

    public function getAllUsers(Request $request)
    {
        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'last_name',
            3 =>'email',
            4 =>'adresa',
            5 =>'is_admin',
            6 =>'dep_name',
            7=> 'action1',
            8=> 'action2',
 
         );
 
         $totalData = User::count();
         $limit = $request->input('length');
         $start = $request->input('start');
         $order = $columns[$request->input('order.0.column')];
         $dir = $request->input('order.0.dir');
 
         if(empty($request->input('search.value'))){
             $posts = DB::table('users')
                 ->join('departments', 'users.dep_fk', '=', 'departments.dep_id')
                 ->select('users.*', 'departments.dep_name as dep_name','departments.dep_id')
                 ->offset($start)
                 ->limit($limit)
                 ->orderBy($order,$dir)
                 ->get();
             $totalFiltered = User::count();
         }else{
             $search = $request->input('search.value');
             $posts = DB::table('users')
                 ->join('departments', 'users.dep_fk', '=', 'departments.dep_id')
                 ->select('users.*', 'departments.dep_name as dep_name','departments.dep_id')
                 -> where('name', 'like', "%{$search}%")
                 ->orWhere('email','like',"%{$search}%")
                 ->orWhere('last_name','like',"%{$search}%")
                 ->orWhere('adresa','like',"%{$search}%")
                 ->orWhere('dep_name','like',"%{$search}%")
                 ->offset($start)
                 ->limit($limit)
                 ->orderBy($order, $dir)
                 ->get();
             $totalFiltered = User::where('name', 'like', "%{$search}%")
                 ->orWhere('email','like',"%{$search}%")
                 ->count();
         }
            $response = array("posts" => $posts , 
            "totalFiltered" =>$totalFiltered);
            return $response;
    }
}