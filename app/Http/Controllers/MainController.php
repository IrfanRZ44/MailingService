<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Storage;
use Carbon;
use Validator;
// use App\Exports\UsersMerchantExport;
// use App\Exports\UsersPelangganExport;
// use App\Exports\KlaimPenjualanExport;
// use App\Imports\KlaimPenjualanImport;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    private $folderFileKlaimPenjualan = "/excel/";
    
    private function getDateTime(){
        $mytime = Carbon\Carbon::now()->timezone('Asia/Makassar');
        $dateTimeNow = $mytime->toDateTimeString();
        return $dateTimeNow;
    }

    private function getTimeStamp(){
        $mytime = Carbon\Carbon::now()->timezone('Asia/Makassar');
        $timeStamp = $mytime->timestamp;
        return $timeStamp;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'etUsername' => 'required',
            'etPassword' => 'required',
        ]);

        if ($validator->fails()) {    
            return redirect()->back()->with(['status' => $validator->messages()->first()]);
        }
        else{
            $akun = session('user');
        
            if($akun != null){
                return redirect('/main/');
            }
            else{
                if($request->etUsername == "admin" && $request->etPassword == "admin"){
                    session(['user' => 'admin']);
                    return redirect('/main/');
                }
                else{
                    if($request->etUsername != "admin"){
                        return redirect()->back()->with(['status' => "Username not found!"]);
                    }
                    else if($request->etPassword != "admin"){
                        return redirect()->back()->with(['status' => "Wrong Password!"]);
                    }
                    else{
                        return redirect()->back()->with(['status' => "Sorry, database error occurred"]);
                    }
                }
            }
        }
    }

    public function logout(){
        session(['user' => null]);
        return redirect('/');
    }

    public function main(){
        $akun = session('user');

        if($akun != null){
            return view("/welcome", ['dataUser' => $akun]);
        }
        else{
            return redirect('/');
        }
    }
}