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

class StuffController extends Controller
{

    public function announcement(){
        if(Session::get('loginstaff')==true){
            $announce = Announcement::orderby('created_at','DESC')->get();
            return view('backstaff.announcements.index',compact('announce'));
        }else{
            return redirect('investor_relations');
        }

      }
      public function detailannouncement($id){
        if(Session::get('loginstaff')==true){
        $data = Announcement::where('id',base64_decode($id))->first();
        return view('backstaff.announcements.detail',compact('data'));
        }else{
            return redirect('investor_relations');
        }
      }
      public function handbook(){
        if(Session::get('loginstaff')==true){
        $announce = Announcement::orderby('created_at','DESC')->get();
        return view('backstaff.handbook.index',compact('announce'));
    }else{
        return redirect('investor_relations');
    }
      }
      public function detailhandbook(){
        if(Session::get('loginstaff')==true){
        $announce = Announcement::orderby('created_at','DESC')->get();
        return view('backstaff.handbook.detail',compact('announce'));
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
            'stuff_id'=>$r->stuff_id,
        ];
        try {
            Stuff::where('id',$r->id)->update($data);
            return back()->with('success','data successfully updated');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }else{
        return redirect('investor_relations');
    }
      }

      public function setting(){
        if(Session::get('loginstaff')==true){
        $data = Stuff::where('id',Session::get('id_staff'))->first();
        return view('backstaff.setting.index',compact('data'));
        }else{
            return redirect('investor_relations');
        }
      }

      public function login(Request $r){

        try {
            $c = Stuff::where('username',$r->username)->where('password',md5($r->password))->count();
            if($c > 0){
                $c = Stuff::where('username',$r->username)->where('password',md5($r->password))->first();
                Session::put('loginstaff',true);
                Session::put('id_staff',$c->id);
                return redirect(route('staff.announcements'));
            }else{
                return back()->with('dangger','Account not found');
            }
        } catch (\Throwable $th) {
            print $th->getmessage();
        }

      }
      public function logoutstuff(){
        Session::forget('loginstaff');
        Session::forget('id_staff');
        return redirect('investor_relations');
      }
}
