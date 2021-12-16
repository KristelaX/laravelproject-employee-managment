<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class HistoricalSalesReport extends Controller
{
    //
    public function getreport()
    {
		$report_name = "system/Blank_A4";
        return view('reports', array('report_name' => $report_name));
    }

	public function getviewsalesreport($id)
    {
		$report_name = "system/Blank_A4";
        return view('historicalsalesreport', array('report_name' => $report_name));
    }

    public function openReport(Request $request , $source)
	{
		$url = $request->input("url1");
		$params = $request->input("params");
		$full_url = $url."&params=".$params;
		
		$time= date("YmdHis");
		// $filepath = "/reports/Blank_A4_.{$source}"; 
		// $filepathtoreturn = "/reports/Blank_A4_.{$source}"; 

		$filepath = "storage/reports/Raport_Ditor_Punonjes_{$time}.{$source}"; 
		$filepathtoreturn = "/storage/reports/Raport_Ditor_Punonjes_{$time}.{$source}";

		$this->file_get_contents_tofile($full_url, $filepath);
		
		echo json_encode($filepathtoreturn);

	}

	
	public function file_get_contents_tofile($url, $filepath)
	{
		$fh = fopen($filepath, 'w+');
		if ($fh) {
			fwrite($fh, file_get_contents($url));
			fclose($fh);
		}
	}
    
}
