<?php

namespace App\Http\Controllers\ace;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Mail;
use Cache;
use Cookie;
use App\Models\Cart;
use App\Models\Page;
use App\Models\Blog;
use App\Models\Shop;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Slider;
use App\Models\Download;
use App\Models\Testimonial;
use App\Models\Announcement;
use App\Models\Persentation;
use App\Models\CombinedOrder;
use App\Models\Patner;
use App\Models\Product;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\Messageceo;
use App\Models\Patnerrequest;
use App\Models\PickupPoint;
use Illuminate\Support\Str;
use App\Models\ProductQuery;
use Illuminate\Http\Request;
use App\Models\AffiliateConfig;
use App\Models\CustomerPackage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Auth\Events\PasswordReset;
use App\Mail\SecondEmailVerifyMailManager;
use App\Models\Stuff;
use Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Faker\Provider\Uuid;
use DB;

class StuffController extends Controller
{

    public function announcement(){
        if(Session::get('loginstaff')==true){
            $announce = Announcement::where('type','PRIVATE')->orderby('created_at','DESC')->get();
            return view('backstaff.announcements.index',compact('announce'));
        }else{
            return redirect('investor_relations');
        }

      }
      public function detailannouncement($id){
        if(Session::get('loginstaff')==true){

        $data = Announcement::where('id',base64_decode($id))->first();
        updatelasttime();
        updatelog(Session::get('id_staff'),'Read Announcements');
        return view('backstaff.announcements.detail',compact('data'));
        }else{
            return redirect('investor_relations');

        }
      }
      public function handbook(){
        if(Session::get('loginstaff')==true){
        $data = DB::table('handbook')->where('published','1')->orderby('effective','DESC')->get();
        return view('backstaff.handbook.index',compact('data'));
    }else{
        return redirect('investor_relations');
    }
      }
      public function detailhandbook($file){
        if(Session::get('loginstaff')==true){
        $handbook = DB::table('handbook')->where('published','1')->where('file',base64_decode($file))->first();
        if(!empty($handbook)){
            updatelasttime();
            // updatelog(Session::get('id_staff'),'Read Handbook');
            return view('backstaff.handbook.detail',compact('handbook'));
        }else{
            return redirect('staff/back/handbook');
        }

    }else{
        return redirect('investor_relations');
    }
      }
    public function anti(){
        if(Session::get('loginstaff')==true){

        $announce = Announcement::orderby('created_at','DESC')->get();
        updatelasttime();
        // updatelog(Session::get('id_staff'),'Read Anti Bribery');
        return view('backstaff.handbook.anti_bribery',compact('announce'));
    }else{
        return redirect('investor_relations');
    }
      }

      public function ethic(){
        if(Session::get('loginstaff')==true){
        $announce = Announcement::orderby('created_at','DESC')->get();
        updatelasttime();
        // updatelog(Session::get('id_staff'),'Ethic and Compliance');
        return view('backstaff.handbook.ethic',compact('announce'));
    }else{
        return redirect('investor_relations');
    }
      }


      public function update(Request $r){
        if(Session::get('loginstaff')==true){
        $data=[
            'name'=>$r->name,
            'email'=>$r->email,
            'position'=>$r->position,
            'display_name'=>$r->display_name,
            'stuff_id'=>$r->stuff_id,
            'username'=>str_replace(' ', '',$r->stuff_id)
        ];
        try {
            Stuff::where('id',$r->id)->update($data);
            updatelasttime();
            updatelog(Session::get('id_staff'),'Update Profil');
            return back()->with('success','data successfully updated');
        } catch (\Throwable $th) {
            return back()->with('danger',$th->getmessage());
        }
    }else{
        return redirect('investor_relations');
    }
      }

      public function agreestaff(Request $r){
        if(Session::get('loginstaff')==true){
            $isChecked = $r->input('isChecked');
            $type  = $r->type;
            if(!empty($isChecked)){
                $check = DB::table('agree')->where('id_staff',Session::get('id_staff'))->where('status',$type)->count();
                if($check > 0){
                    $data=[
                        'checked'=>$isChecked,
                    ];
                    try {
                        DB::table('agree')->where('status',$type)
                                ->where('id_staff',Session::get('id_staff'))
                                ->updtae($data);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }else{
                    $data=[
                        'checked'=>$isChecked,
                        'id_staff'=>Session::get('id_staff'),
                        'status'=>$type
                    ];
                    try {
                        updatelogout(Session::get('id_staff'),'Staff Agree for '.$type);
                        DB::table('agree')->insert($data);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }

            }
        }else{

        }
      }

      public function updatepassword(Request $r){
        if(Session::get('loginstaff')==true){
            $staff = Stuff::where('id',$r->id)->first();
            if($staff != null){
                if($staff->password != md5($r->oldpass)){
                    return back()->with('danger','old password does not match');
                }else{
                    if(md5($r->pass1) != md5($r->pass2)){
                        return back()->with('danger','Password and Confirm Password does not match');
                    }else{
                        $data=[
                            'password'=>md5($r->pass1)
                        ];
                        try {
                            Stuff::where('id',$r->id)->update($data);
                            updatelasttime();
                            updatelog(Session::get('id_staff'),'Update Password');
                            return back()->with('success','Password successfully updated');
                        } catch (\Throwable $th) {
                            return back()->with('danger',$th->getmessage());
                        }
                    }
                }
            }
        }else{
            return redirect('investor_relations');
        }
      }

      public function setting(){
        if(Session::get('loginstaff')==true){
        $data = Stuff::where('id',Session::get('id_staff'))->first();
        updatelasttime();
        updatelog(Session::get('id_staff'),'View Setting');
        return view('backstaff.setting.index',compact('data'));
        }else{
            return redirect('investor_relations');
        }
      }

      public function nextannouncement($date){
        if(Session::get('loginstaff')==true){
            $data = Announcement::where('type','PRIVATE')->where('created_at','>',base64_decode($date))->first();
            if($data != null){
                return view('backstaff.announcements.detail',compact('data'));

            }else{
                return back();
            }

            }else{
                return redirect('investor_relations');
            }
      }


      public function resetpass(Request $r){
       $c = Stuff::where('email',$r->email)->count();
       if($c == 0){
        return back()->with('danger','Email Account not available');
       }else{
        $kode = Str::uuid()->toString();
        $data = [
            'reset_code'=>$kode
        ];
        $act = Stuff::where('email',$r->email)->update($data);
        $array['subject'] = translate('Forgot Password');
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content']="for update password click the link below";
        $array['link'] = env('URL_WEB').'/recoverypassword?kode='.base64_encode($kode);


        Mail::to($r->email)->queue(new SecondEmailVerifyMailManager($array));
        return back()->with('success','Password recovery link sent to email. please check your email');
       }
      }

      public function resetpassword(Request $r){
        $c = Stuff::where('reset_code',$r->reset_code)->count();
        if($c == 0){
         return back()->with('danger','Reset code not Avaliable');
        }else{
            if(md5($r->pass1) != md5($r->pass2)){
                return back()->with('danger','Password and Confirm Password does not match');
            }else{
                $data=[
                    'password'=>md5($r->pass1)
                ];
                try {
                    Stuff::where('reset_code',$r->reset_code)->update($data);
                    return redirect(route('staff.loginback'))->with('success','Password successfully updated');
                } catch (\Throwable $th) {
                    return back()->with('danger',$th->getmessage());
                }
            }
        }
       }





      public function backannouncement($date){
        if(Session::get('loginstaff')==true){
            $data = Announcement::where('type','PRIVATE')->where('created_at','<',base64_decode($date))->first();
            if($data != null){
                return view('backstaff.announcements.detail',compact('data'));
            }else{
                return back();
            }
            }else{
                return redirect('investor_relations');
            }
      }

      public function login(Request $r){

        try {
            $c = Stuff::where('username',str_replace(' ', '',$r->username))->where('password',md5($r->password))->count();
            if($c > 0){
                $blokir =  Stuff::where('username',str_replace(' ', '',$r->username))
                            ->where('password',md5($r->password))
                            ->where('status','!=','A')
                            ->count();
                if($blokir > 0){

                    return view('backstaff.block');

                }else{
                    $c = Stuff::where('username',str_replace(' ', '',$r->username))->where('password',md5($r->password))->first();
                    Session::put('loginstaff',true);
                    Session::put('id_staff',$c->id);
                    updatelog($c->id,'login');
                    return redirect(route('staff.announcements'));
                }

            }else{
                return back()->with('dangger','Account not found');
            }
        } catch (\Throwable $th) {
            print $th->getmessage();
        }

      }
      public function loginview(){
        return view('acewebfront.pages.loginstaff');
      }
      public function logoutstuff(){
        updatelasttime();
        updatelogout(Session::get('id_staff'),'logout');
        Session::forget('loginstaff');
        Session::forget('id_staff');
        return redirect('investor_relations');
      }
}
