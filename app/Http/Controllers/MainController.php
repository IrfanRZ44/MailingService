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
use App\Exports\EmailExport;
use App\Imports\EmailImport;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    private $folderFileEmail = "/excel/";
    
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

    public function index(){
        $akun = session('user');

        if($akun == null){
            return view("/login");
        }
        else{
            return redirect('/main');
        }
    }

    public function download(){
        $akun = session('user');

        if($akun != null){
            return Excel::download(new EmailExport(), 'Email Examples.xlsx');
        }
        else{
            return redirect('/');
        }
    }

    public function sent(Request $request){
        $akun = session('user');
        
        if($akun != null){
            $base_url = url('/');
            $validatorFile = Validator::make($request->all(), [
                'etFile' => 'mimes:xlsx|required'
            ]);

            if ($validatorFile->fails()) {  
                return redirect('/main')->with(['status' => "Error, please select file with xlsx"]);
            }
            else{
                $file = $request->file('etFile');
                $extension = $file->getClientOriginalExtension();
                $name = Str::random(5)."_".$this->getTimeStamp().".".$extension;
                $folder = $this->folderFileEmail;
                $file->move(public_path().$folder, $name);

                $import = new EmailImport;
                Excel::import($import, public_path('excel/'.$name));

                $data = Excel::toArray(new EmailImport, public_path('excel/'.$name));
                try{
                    collect(head($data))
                        ->each(function ($row, $key) {
                            if ($row[0] == "Number" && $row[1] == "Email") {
                                return "asda";
                            }
                            else{
                                return "barus 2";
                            }
                        });
                    
                    return redirect('/main')->with(['status' => "Success"]);
                }
                catch(\Exception $e){
                    return redirect('/main')->with(['status' => "Failed, ".$e->getMessage()]);
                }
            }
        }
        else{
            return redirect('/');
        }
    }
}