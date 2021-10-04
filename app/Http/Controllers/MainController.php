<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use App\Models\Users;
use App\Models\Email;
use App\Mail\OrderShipped;
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
    private $sizeCurrent = 0;
    private $sizeImport = 0;
    private $title = "";
    private $desc = "";
    
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
                $dataUser = Users::where('username', $request->etUsername)->first();
                $md5Password = md5($request->etPassword);

                if($dataUser != null && $dataUser->password == $md5Password){
                    session(['user' => 'admin']);
                    return redirect('/main/');
                }
                else{
                    if($dataUser == null){
                        return redirect()->back()->with(['status' => "Username not found!"]);
                    }
                    else if($dataUser->password != $md5Password){
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
                'etTitle' => 'required',
                'etDesc' => 'required',
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

                $this->sizeImport = $import->getRowCount();

                $data = Excel::toArray(new EmailImport, public_path('excel/'.$name));
                $this->title = $request->etTitle;
                $this->desc = $request->etDesc;

                try{
                    collect(head($data))
                    ->each(function ($row, $key) {
                        if ($row[0] == "Number") {
                        }
                        else{
                            ++$this->sizeCurrent;

                            if ($row[2] != "") {
                                $to_name = $row[1];
                                $to_email = $row[2];
                                
                                $data = array("name" => $row[1], "body" => $this->desc);
                                Mail::send('mail_template', $data, function($message) use ($to_name, $to_email){
                                    $message->to($to_email)
                                    ->subject($this->title);
                                });
                                // Mail::to('irfan.rozal44@gmail.com')->send(new OrderShipped());
                                echo "Email on Row ".$this->sizeCurrent." Succesfully Delivered<br>";
                            }
                            else{
                                echo "Error, Email is empty on row ".$this->sizeCurrent."<br>";
                            }

                            if ($this->sizeCurrent == $this->sizeImport) {
                                dd('Success Sent Email!'); 
                            }
                        }
                    });
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