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
use App\Models\Stuff;
use Illuminate\Support\Str;
use App\Models\ProductQuery;
use Illuminate\Http\Request;
use App\Models\AffiliateConfig;
use App\Models\CustomerPackage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Auth\Events\PasswordReset;
use App\Mail\SecondEmailVerifyMailManager;
use Session;
use Faker\Provider\Uuid;
use PDF;
use DB;
use App\Models\Currency;
use App\Models\Language;
use Config;
use App\Models\Contact;


class AceController extends Controller
{
    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('acewebfront.pages.index');

    }

    public function registerstuff(Request $r){
        $r->validate([
            'fullname'=>'required',
            'displayname' => 'required',
            'stuffid' => 'required',
            'password_confirmation'=>'required',
            'password' => 'required|confirmed',
            'email' => 'required|email|unique:stuffs,email',

        ]);

        try {
            // if($r->stuffid=='19961210'){
                $kode = Str::uuid()->toString();
                $data=[
                    'password'=>md5($r->password),
                    'username'=>$r->stuffid,
                    'display_name'=>$r->displayname,
                    'name'=>$r->fullname,
                    'stuff_id'=>$r->stuffid,
                    'email'=>$r->email,
                    'verify_code'=>$kode,
                ];
                Stuff::insert($data);
                $array['subject'] = translate('registration confirmation');
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['content']="congratulations your registration is almost complete then you need to verify your email address. for verification click the link below";
                $array['link'] = env('URL_WEB').'/comfirregister?kode='.base64_encode($kode);


                Mail::to($r->email)->queue(new SecondEmailVerifyMailManager($array));
                return back()->with('success','To activate the account, please check the account activation in your email');

            // }

        } catch (\Throwable $th) {
            return back()->with('danger',$th->getmessage());
        }

    }

    public function page($page){
        switch ($page) {

            case 'recoverypassword':
                try {
                    $c = Stuff::where('reset_code',base64_decode($_GET['kode']))->count();
                    if($c > 0){
                        $code = base64_decode($_GET['kode']);
                        return view('acewebfront.pages.forgotpassconfirmation',compact('code'));
                    }
                } catch (\Throwable $th) {
                    print $th->getmessage();
                }
                break;

            case 'comfirregister':
                try {
                    $data=[
                        'status'=>'A'
                    ];
                    Stuff::where('verify_code',base64_decode($_GET['kode']))->update($data);
                    // $info = Stuff::where('verify_code',base64_decode($_GET['kode']))->first();
                    // Session::put("loginstaff",true);
                    // Session::put('id_staff',$info->id);

                    return redirect(route('staff.loginback'))->with('success','
                    congratulations successful activation');
                } catch (\Throwable $th) {
                    print $th->getmessage();
                }
                break;

            case 'updatecronjob':
                updatecronjob();
                break;

            case 'testsendemail':
                $no ='20230522-10362810';
                $email = 'bohati@silverstream.my';
                sendinvoice($no,$email);
                break;
            case 'fpx':
                if(isset($_GET['transactionId'])){
                    $id = $_GET['transactionId'];
                    if (get_setting('m1_sandbox') == 1) {
                        $url    = 'https://keycloak.m1pay.com.my/auth/realms/master/protocol/openid-connect/token';
                        $token  = gettokenm1payment($url)->access_token;
                        if (get_setting('m1_sandbox') == 1) {
                            $url    = 'https://gateway-uat.m1pay.com.my/m1paywall/api/m-1-pay-transactions/'.$id;
                        }
                        else {
                            $url    = 'https://gateway.m1pay.com.my/wall/api/m-1-pay-transactions/'.$id;
                        }
                        $body = [
                            'transactionId'=>$id
                        ];
                         try {
                            $maxAttempts = 3000; // Maximum number of attempts
                            $attempt = 0;
                            do {
                                // Set cURL options
                                $crl = curl_init();
                                curl_setopt($crl, CURLOPT_URL, $url);
                                curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt( $crl, CURLOPT_CUSTOMREQUEST, 'GET' );
                                curl_setopt( $crl, CURLOPT_POSTFIELDS, $body );
                                curl_setopt($crl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Authorization: Bearer'.$token ));


                                $response = curl_exec($crl);
                                // Check for cURL errors
                                if ($response === false) {
                                    $attempt++;
                                    curl_close($crl);
                                    if ($attempt >= $maxAttempts) {
                                        echo "Maximum attempts reached. Exiting loop.";
                                        break;
                                    }
                                } else {
                                    // If the response is successful, exit the loop
                                    break;
                                }
                            } while (true);
                                // Close the cURL resource
                                curl_close($crl);
                                // Process the response or handle it in your desired way
                                $data = json_decode($response);
                                $status = $data->transactionStatus;
                                if($status=='APPROVED'){
                                    $merchantno = $data->merchantOrderNo;
                                    $email      = $data->emailAddress;
                                    $merchantno = $data->merchantOrderNo;
                                    $email      = $data->emailAddress;
                                    try{
                                        $d = [
                                        "transactionId"=> $data->transactionId,
                                        "transactionStatus"=> $data->transactionStatus,
                                        "productDescription"=> $data->productDescription,
                                        "transactionAmount"=> $data->transactionAmount,
                                        "transactionAmountConverted"=> $data->transactionAmountConverted,
                                        "channel"=> $data->channel,
                                        "exchangeOrderNo"=> $data->exchangeOrderNo,
                                        "merchantOrderNo"=> $data->merchantOrderNo,
                                        "transactionCurrency"=> $data->transactionCurrency,
                                        "createdDate"=> $data->createdDate,
                                        "modifiedDate"=> (property_exists($data, 'modifiedDate')) ? $data->modifiedDate : "Null",
                                        "merchantId"=> $data->merchantId,
                                        "merchantCallBackUrl"=> $data->merchantCallBackUrl,
                                        "merchantRedirectUrl"=> $data->merchantRedirectUrl,
                                        "phoneNumber"=> $data->phoneNumber,
                                        "emailAddress"=> $data->emailAddress,
                                        "authorisedChannels"=> implode(' ',$data->authorisedChannels),
                                        "skipConfirmation"=>$data->skipConfirmation
                                    ];
                                    $cfpx = DB::table('fpxcalback')->where('transactionId',$data->transactionId)->count();
                                    if($cfpx > 0){
                                        DB::table('fpxcalback')->where('transactionId',$data->transactionId)->update($d);
                                    }else{
                                        DB::table('fpxcalback')->insert($d);
                                    }
                                    return updateorderm1($merchantno,$email);
                                    }catch (\Throwable $th) {
                                        print $th->getMessage();
                                    }
                                }elseif($status=='REQUEST'){
                                    try{
                                        $d = [
                                        "transactionId"=> $data->transactionId,
                                        "transactionStatus"=> $data->transactionStatus,
                                        "productDescription"=> $data->productDescription,
                                        "transactionAmount"=> $data->transactionAmount,
                                        "transactionAmountConverted"=> $data->transactionAmountConverted,
                                        "channel"=> $data->channel,
                                        "exchangeOrderNo"=> $data->exchangeOrderNo,
                                        "merchantOrderNo"=> $data->merchantOrderNo,
                                        "transactionCurrency"=> $data->transactionCurrency,
                                        "createdDate"=> $data->createdDate,
                                        "modifiedDate"=> (property_exists($data, 'modifiedDate')) ? $data->modifiedDate : "Null",
                                        "merchantId"=> $data->merchantId,
                                        "merchantCallBackUrl"=> $data->merchantCallBackUrl,
                                        "merchantRedirectUrl"=> $data->merchantRedirectUrl,
                                        "phoneNumber"=> $data->phoneNumber,
                                        "emailAddress"=> $data->emailAddress,
                                        "authorisedChannels"=> implode(' ',$data->authorisedChannels),
                                        "skipConfirmation"=>$data->skipConfirmation
                                    ];
                                    $cfpx = DB::table('fpxcalback')->where('transactionId',$data->transactionId)->count();
                                    if($cfpx > 0){
                                        DB::table('fpxcalback')->where('transactionId',$data->transactionId)->update($d);
                                    }else{
                                        DB::table('fpxcalback')->insert($d);
                                        $payment =[
                                            'payment_status'=>$data->transactionStatus
                                        ];
                                        $act = Order::where('code',$data->merchantOrderNo)->update($payment);
                                        $order = Order::where('code',$data->merchantOrderNo)->first();
                                    }

                                    return redirect('/our_products/view/payment_select');

                                    }catch (\Throwable $th) {
                                        print $th->getMessage();
                                    }
                                }
                                else{
                                    try{
                                        $d = [
                                        "transactionId"=> $data->transactionId,
                                        "transactionStatus"=> $data->transactionStatus,
                                        "productDescription"=> $data->productDescription,
                                        "transactionAmount"=> $data->transactionAmount,
                                        "transactionAmountConverted"=> $data->transactionAmountConverted,
                                        "channel"=> $data->channel,
                                        "exchangeOrderNo"=> $data->exchangeOrderNo,
                                        "merchantOrderNo"=> $data->merchantOrderNo,
                                        "transactionCurrency"=> $data->transactionCurrency,
                                        "createdDate"=> $data->createdDate,
                                        "modifiedDate"=> (property_exists($data, 'modifiedDate')) ? $data->modifiedDate : "Null",
                                        "merchantId"=> $data->merchantId,
                                        "merchantCallBackUrl"=> $data->merchantCallBackUrl,
                                        "merchantRedirectUrl"=> $data->merchantRedirectUrl,
                                        "phoneNumber"=> $data->phoneNumber,
                                        "emailAddress"=> $data->emailAddress,
                                        "authorisedChannels"=> implode(' ',$data->authorisedChannels),
                                        "skipConfirmation"=>$data->skipConfirmation
                                    ];
                                    $cfpx = DB::table('fpxcalback')->where('transactionId',$data->transactionId)->count();
                                    if($cfpx > 0){
                                        DB::table('fpxcalback')->where('transactionId',$data->transactionId)->update($d);
                                    }else{
                                        DB::table('fpxcalback')->insert($d);
                                        $payment =[
                                            'payment_status'=>$data->transactionStatus
                                        ];
                                        $act = Order::where('code',$data->merchantOrderNo)->update($payment);
                                        $order = Order::where('code',$data->merchantOrderNo)->first();
                                    }

                                    return redirect()->route('order_confirmed_other');

                                    }catch (\Throwable $th) {
                                        print $th->getMessage();
                                    }
                                }

                            } catch (\Throwable $th) {
                                // print "have some mistake need to reload";
                                return redirect('fpx?transactionId='.$_GET['transactionId']);
                            }



                    }
                    else {
                        $url    = 'https://keycloak.m1pay.com.my/auth/realms/m1pay-users/protocol/openid-connect/token';
                        $token  = gettokenm1payment($url)->access_token;
                        $url    = 'https://gateway.m1pay.com.my/wall/api/m-1-pay-transactions/'.$id;
                        $body = [
                            'transactionId'=>$id
                        ];
                         try {
                            $maxAttempts = 3000; // Maximum number of attempts
                            $attempt = 0;
                            do {
                                // Set cURL options
                                $crl = curl_init();
                                curl_setopt($crl, CURLOPT_URL, $url);
                                curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt( $crl, CURLOPT_CUSTOMREQUEST, 'GET' );
                                curl_setopt( $crl, CURLOPT_POSTFIELDS, $body );
                                curl_setopt($crl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Authorization: Bearer'.$token ));


                                $response = curl_exec($crl);
                                // Check for cURL errors
                                if ($response === false) {
                                    $attempt++;
                                    curl_close($crl);
                                    if ($attempt >= $maxAttempts) {
                                        echo "Maximum attempts reached. Exiting loop.";
                                        break;
                                    }
                                } else {
                                    // If the response is successful, exit the loop
                                    break;
                                }
                            } while (true);
                                // Close the cURL resource
                                curl_close($crl);
                                // Process the response or handle it in your desired way
                                $data = json_decode($response);
                                $status = $data->transactionStatus;
                                if($status=='APPROVED'){
                                    $merchantno = $data->merchantOrderNo;
                                    $email      = $data->emailAddress;
                                    try{
                                        $d = [
                                        "transactionId"=> $data->transactionId,
                                        "transactionStatus"=> $data->transactionStatus,
                                        "productDescription"=> $data->productDescription,
                                        "transactionAmount"=> $data->transactionAmount,
                                        "transactionAmountConverted"=> $data->transactionAmountConverted,
                                        "channel"=> $data->channel,
                                        "exchangeOrderNo"=> $data->exchangeOrderNo,
                                        "merchantOrderNo"=> $data->merchantOrderNo,
                                        "transactionCurrency"=> $data->transactionCurrency,
                                        "createdDate"=> $data->createdDate,
                                        "modifiedDate"=> (property_exists($data, 'modifiedDate')) ? $data->modifiedDate : "Null",
                                        "merchantId"=> $data->merchantId,
                                        "merchantCallBackUrl"=> $data->merchantCallBackUrl,
                                        "merchantRedirectUrl"=> $data->merchantRedirectUrl,
                                        "phoneNumber"=> $data->phoneNumber,
                                        "emailAddress"=> $data->emailAddress,
                                        "authorisedChannels"=> implode(' ',$data->authorisedChannels),
                                        "skipConfirmation"=>$data->skipConfirmation
                                    ];
                                    $cfpx = DB::table('fpxcalback')->where('transactionId',$data->transactionId)->count();
                                    if($cfpx > 0){
                                        DB::table('fpxcalback')->where('transactionId',$data->transactionId)->update($d);
                                    }else{
                                        DB::table('fpxcalback')->insert($d);
                                    }
                                    return updateorderm1($merchantno,$email);
                                    }catch (\Throwable $th) {
                                        print $th->getMessage();
                                    }

                                }elseif($status=='REQUEST'){
                                    try{
                                        $d = [
                                        "transactionId"=> $data->transactionId,
                                        "transactionStatus"=> $data->transactionStatus,
                                        "productDescription"=> $data->productDescription,
                                        "transactionAmount"=> $data->transactionAmount,
                                        "transactionAmountConverted"=> $data->transactionAmountConverted,
                                        "channel"=> $data->channel,
                                        "exchangeOrderNo"=> $data->exchangeOrderNo,
                                        "merchantOrderNo"=> $data->merchantOrderNo,
                                        "transactionCurrency"=> $data->transactionCurrency,
                                        "createdDate"=> $data->createdDate,
                                        "modifiedDate"=> (property_exists($data, 'modifiedDate')) ? $data->modifiedDate : "Null",
                                        "merchantId"=> $data->merchantId,
                                        "merchantCallBackUrl"=> $data->merchantCallBackUrl,
                                        "merchantRedirectUrl"=> $data->merchantRedirectUrl,
                                        "phoneNumber"=> $data->phoneNumber,
                                        "emailAddress"=> $data->emailAddress,
                                        "authorisedChannels"=> implode(' ',$data->authorisedChannels),
                                        "skipConfirmation"=>$data->skipConfirmation
                                    ];
                                    $cfpx = DB::table('fpxcalback')->where('transactionId',$data->transactionId)->count();
                                    if($cfpx > 0){
                                        DB::table('fpxcalback')->where('transactionId',$data->transactionId)->update($d);
                                    }else{
                                        DB::table('fpxcalback')->insert($d);
                                        $payment =[
                                            'payment_status'=>$data->transactionStatus
                                        ];
                                        $act = Order::where('code',$data->merchantOrderNo)->update($payment);
                                        $order = Order::where('code',$data->merchantOrderNo)->first();
                                    }

                                    return redirect('/our_products/view/payment_select');

                                    }catch (\Throwable $th) {
                                        print $th->getMessage();
                                    }
                                }else{
                                    try{
                                        $d = [
                                        "transactionId"=> $data->transactionId,
                                        "transactionStatus"=> $data->transactionStatus,
                                        "productDescription"=> $data->productDescription,
                                        "transactionAmount"=> $data->transactionAmount,
                                        "transactionAmountConverted"=> $data->transactionAmountConverted,
                                        "channel"=> $data->channel,
                                        "exchangeOrderNo"=> $data->exchangeOrderNo,
                                        "merchantOrderNo"=> $data->merchantOrderNo,
                                        "transactionCurrency"=> $data->transactionCurrency,
                                        "createdDate"=> $data->createdDate,
                                        "modifiedDate"=> (property_exists($data, 'modifiedDate')) ? $data->modifiedDate : "Null",
                                        "merchantId"=> $data->merchantId,
                                        "merchantCallBackUrl"=> $data->merchantCallBackUrl,
                                        "merchantRedirectUrl"=> $data->merchantRedirectUrl,
                                        "phoneNumber"=> $data->phoneNumber,
                                        "emailAddress"=> $data->emailAddress,
                                        "authorisedChannels"=> implode(' ',$data->authorisedChannels),
                                        "skipConfirmation"=>$data->skipConfirmation
                                    ];
                                    $cfpx = DB::table('fpxcalback')->where('transactionId',$data->transactionId)->count();
                                    if($cfpx > 0){
                                        DB::table('fpxcalback')->where('transactionId',$data->transactionId)->update($d);
                                    }else{
                                        DB::table('fpxcalback')->insert($d);
                                        $payment =[
                                            'payment_status'=>$data->transactionStatus
                                        ];
                                        $act = Order::where('code',$data->merchantOrderNo)->update($payment);
                                        $order = Order::where('code',$data->merchantOrderNo)->first();
                                    }

                                    return redirect()->route('order_confirmed_other');

                                    }catch (\Throwable $th) {
                                        print $th->getMessage();
                                    }


                                }

                            } catch (\Throwable $th) {
                                // print "have some mistake need to reload";
                                return redirect('fpx?transactionId='.$_GET['transactionId']);
                            }
                    }


                }else{
                   if($_POST['transactionAmount']!=null){
                    $d = [
                        "transactionId"=> $_POST['transactionId'],
                        "transactionStatus"=> $_POST['transactionStatus'],
                        "productDescription"=> $_POST['productDescription'],
                        "transactionAmount"=> $_POST['transactionAmount'],
                        "transactionAmountConverted"=> $_POST['transactionAmountConverted'],
                        "channel"=> $_POST['channel'],
                        "exchangeOrderNo"=> $_POST['exchangeOrderNo'],
                        "merchantOrderNo"=> $_POST['merchantOrderNo'],
                        "transactionCurrency"=> $_POST['transactionCurrency'],
                        "createdDate"=> $_POST['createdDate'],
                        "modifiedDate"=> $_POST['modifiedDate'],
                        "merchantId"=> $_POST['merchantId'],
                        "merchantCallBackUrl"=> $_POST['merchantCallBackUrl'],
                        "merchantRedirectUrl"=> $_POST['merchantRedirectUrl'],
                        "phoneNumber"=> $_POST['phoneNumber'],
                        "emailAddress"=> $_POST['emailAddress'],
                        "authorisedChannels"=> implode(' ',$_POST['authorisedChannels']),
                        "skipConfirmation"=>$_POST['skipConfirmation']
                    ];
                    DB::table('fpxcalback')->insert($d);
                    $payment =[
                        'payment_status'=>$data->transactionStatus
                    ];
                    $act = Order::where('code',$_POST['merchantOrderNo'])->update($payment);
                    }
                }
                 break;
            case 'callfpx':
                if(isset($_POST['transactionAmount'])){
                    $data=[
                        'transactionAmount'=>$_POST['transactionAmount'],
                        'fpxTxnId'=>$_POST['fpxTxnId'],
                        'merchantOrderNo'=>$_POST['merchantOrderNo'],
                        'status'=>$_POST['status'],
                        'sellerOrderNo'=>$_POST['sellerOrderNo'],
                        'description'=>$_POST['description'],
                        'signedData'=>$_POST['signedData'],
                       ];
                       $act = DB::table('fpxcalback')->insert($data);
                }
                break;

            case 'signdby':
                print getsignm1payment('test');
                break;
            case 'forpersonal':
                 return redirect('forcorporate');
                break;

            case 'ourcompany':
                $featured_categories = Cache::rememberForever('featured_categories', function () {
                    return Category::where('featured', 1)->get();
                });

                $todays_deal_products = Cache::rememberForever('todays_deal_products', function () {
                    return filter_products(Product::where('published', 1)->where('todays_deal', '1'))->get();
                });

                $newest_products = Cache::remember('newest_products', 3600, function () {
                    return filter_products(Product::latest())->limit(12)->get();
                });
                $achievement = Blog::select('blogs.id as id','blogs.title as title','blogs.slug as slug','blogs.short_description as short_description','blogs.description as description','blogs.banner as banner','uploads.file_name as file_name')->join('uploads','uploads.id','blogs.banner')->join('blog_categories','blog_categories.id','blogs.category_id')->where('status','1')->where('category_name','CORPORATE')->orderby('blogs.created_at','DESC')->get();
                $slider      =  Slider::select('sliders.id as id','sliders.caption as caption','sliders.sub_caption','uploads.file_name as file_name')->join('uploads','uploads.id','sliders.image')->where('sliders.type','CORPORATE')->get();
                $testimonial =  Testimonial::select('testimonials.id as id','testimonials.person as person','testimonials.position as position','testimonials.content as content','uploads.file_name as file_name','testimonials.type as type')->join('uploads','uploads.id','testimonials.image')->where('testimonials.type','CO')->get();
                $patner      =  Patner::select('patners.id as id','patners.company as company','uploads.file_name as file_name')->join('uploads','uploads.id','patners.image')->groupby('id')->get();
                return view('acewebfront.pages.home', compact('achievement','featured_categories', 'todays_deal_products', 'newest_products','slider','testimonial','patner','page'));
                break;
                case 'forcorporate2':
                    $featured_categories = Cache::rememberForever('featured_categories', function () {
                        return Category::where('featured', 1)->get();
                    });

                    $todays_deal_products = Cache::rememberForever('todays_deal_products', function () {
                        return filter_products(Product::where('published', 1)->where('todays_deal', '1'))->get();
                    });

                    $newest_products = Cache::remember('newest_products', 3600, function () {
                        return filter_products(Product::latest())->limit(12)->get();
                    });
                    $achievement = Blog::join('uploads','uploads.id','blogs.banner')->where('status','1')->orderby('blogs.created_at','DESC')->take(4)->get();
                    $slider      =  Slider::select('sliders.id as id','sliders.caption as caption','sliders.sub_caption','uploads.file_name as file_name')->join('uploads','uploads.id','sliders.image')->get();
                    $testimonial =  Testimonial::select('testimonials.id as id','testimonials.person as person','testimonials.position as position','testimonials.content as content','uploads.file_name as file_name')->join('uploads','uploads.id','testimonials.image')->get();
                    $patner      =  Patner::select('patners.id as id','patners.company as company','uploads.file_name as file_name')->join('uploads','uploads.id','patners.image')->groupby('id')->get();
                    return view('acewebfront.pages.homeedit', compact('achievement','featured_categories', 'todays_deal_products', 'newest_products','slider','testimonial','patner','page'));
                    break;
            case 'forcorporate':
                $slider      =  Slider::select('sliders.id as id','sliders.caption as caption','sliders.sub_caption','uploads.file_name as file_name')->join('uploads','uploads.id','sliders.image')->where('sliders.type','PERSONAL')->get();
                $blog = Blog::select('blogs.id as id','blogs.title as title','blogs.slug as slug','blogs.short_description as short_description','blogs.description as description','blogs.banner as banner','uploads.file_name as file_name')->join('uploads','uploads.id','blogs.banner')->join('blog_categories','blog_categories.id','blogs.category_id')->where('status','1')->where('category_name','PERSONAL')->orderby('blogs.created_at','DESC')->take(6)->get();
                $testimonial = Testimonial::where('type','PO')->orderby('id','desc')->get();
                return view('acewebfront.pages.personal',compact('blog','page','testimonial','slider'));
                break;
            case 'registerstaff':
                return view('acewebfront.pages.register');
                break;
            case 'forgotpass':
                    return view('acewebfront.pages.forgotpass');
                    break;
            case 'investor_relations':
                $irkey = Blog::join('blog_categories','blog_categories.id','blogs.category_id')
                        ->where('category_name','Financial Results : Key Points')
                        ->first();
                $shareholder =  Blog::join('blog_categories','blog_categories.id','blogs.category_id')
                        ->where('category_name','shareholder')
                        ->first();
                $ceo             = Messageceo::limit(1)->first();
                $announcement    = Announcement::orderby('created_at','DESC')->where('type','PUBLIC')->get();
                $announcementnew = Announcement::orderby('created_at','DESC')->where('type','PUBLIC')->first();
                $download     = Download::orderby('date','DESC')->get();
                return view('acewebfront.pages.investor',compact('ceo','irkey','announcement','download','shareholder','page','announcementnew'));
                break;
            case 'our_products':
                $data = Product::where('published','1')->orderby('shortby','ASC')->paginate(6);
                return view('acewebfront.pages.product',compact('data','page'));
            break;
            case 'newsroom':
                $category = (isset($_GET['category'])) ? $_GET['category']:'ALL';
                if($category=='ALL'){
                    $data = Blog::select('blogs.title as title','blogs.banner as banner','blogs.slug as slug')->join('blog_categories','blog_categories.id','blogs.category_id')->orderby('blogs.created_at','DESC')->where('status','1')->where('category_name','CORPORATE')->OrWHERE('category_name','PERSONAL')->OrWhere('category_name','AIAB')->paginate(6);
                }else{
                    $data = Blog::select('blogs.title as title','blogs.banner as banner','blogs.slug as slug')->join('blog_categories','blog_categories.id','blogs.category_id')->orderby('blogs.created_at','DESC')->where('status','1')->where('category_name',$_GET['category'])->paginate(6);
                }
                // $data = Blog::select('blogs.title as title','blogs.banner as banner','blogs.slug as slug')->join('blog_categories','blog_categories.id','blogs.category_id')->orderby('blogs.created_at','DESC')->where('category_name','CORPORATE')->OrWHERE('category_name','PERSONAL')->OrWhere('category_name','AIAB')->paginate(6);
                return view('acewebfront.pages.newsroom',compact('data','page'));
                break;
            case 'contact':
                $hQContact = Contact::where('orderto',1)->first();
                $contacts  = Contact::where('orderto','!=',1)->orderBy('orderto','asc')->get();
                return view('acewebfront.pages.contact',compact('page','hQContact','contacts'));
                break;
            default:
                return redirect()->route('home');
                break;
        }
    }

    public function strToHex($string){
      $hex = '';
      for ($i=0; $i<strlen($string); $i++){
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex .= substr('0'.$hexCode, -2);
      }
        return strToUpper($hex);
    }

    public function pageslug($page,$slug){
        switch ($page) {
            case 'tracking':
                return view('acewebfront.pages.tracking');
                break;
            case 'view_pdf':
                if($slug=='Terms & Condition'){
                    return redirect('/public/aceweb/pdf/Terms & Condition.pdf');
                }if($slug=='Product Disclosure'){
                    return redirect('/public/aceweb/pdf/Product Disclosure.pdf');
                }
                if($slug=='terms'){
                    return redirect('/public/aceweb/pdf/Terms & Condition.pdf');
                }if($slug=='product'){
                    return redirect('/public/aceweb/pdf/Product Disclosure.pdf');
                }
                break;
            case 'investor_relations':
                if($slug=='message_from_ceo'){
                    $data = Messageceo::find('1');
                    return view('acewebfront.pages.detail.messagefromceo',compact('data'));
                }elseif ($slug=='All-Persentations') {
                    $data = Persentation::orderby('date','DESC')->get();
                    return view('acewebfront.pages.detail.detailpersentation',compact('data'));
                }
                else{
                    $data = Blog::join('blog_categories','blog_categories.id','blogs.category_id')->where('blog_categories.slug',$slug)->first();
                    return view('acewebfront.pages.detail.detailinvestor',compact('data'));
                }
                break;
            case 'newsroom':
                $data = Blog::where('slug',$slug)->first();
                if(!empty($data)){
                    updatecountview($data->id);
                    return view('acewebfront.pages.detail.detailnews',compact('data'));
                }
                break;
            case 'announcements':
                $data = Announcement::where('slug',$slug)->first();
                return view('acewebfront.pages.detail.detailannouncement',compact('data'));
                break;
            case 'our_products':
                return $this->Product('our_products',$slug);
                break;


            case 'printinvoice':

                if(Session::has('currency_code')){
                    $currency_code = Session::get('currency_code');
                }
                else{
                    $currency_code = Currency::findOrFail(get_setting('system_default_currency'))->code;
                }
                $language_code = Session::get('locale', Config::get('app.locale'));

                if(Language::where('code', $language_code)->first()->rtl == 1){
                    $direction = 'rtl';
                    $text_align = 'right';
                    $not_text_align = 'left';
                }else{
                    $direction = 'ltr';
                    $text_align = 'left';
                    $not_text_align = 'right';
                }

                if($currency_code == 'BDT' || $language_code == 'bd'){
                    // bengali font
                    $font_family = "'Hind Siliguri','sans-serif'";
                }elseif($currency_code == 'KHR' || $language_code == 'kh'){
                    // khmer font
                    $font_family = "'Hanuman','sans-serif'";
                }elseif($currency_code == 'AMD'){
                    // Armenia font
                    $font_family = "'arnamu','sans-serif'";
                // }elseif($currency_code == 'ILS'){
                //     // Israeli font
                //     $font_family = "'Varela Round','sans-serif'";
                }elseif($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD' || $language_code == 'ir' || $language_code == 'om' || $currency_code == 'ROM' || $currency_code == 'SDG' || $currency_code == 'ILS'|| $language_code == 'jo'){
                    // middle east/arabic/Israeli font
                    $font_family = "'Baloo Bhaijaan 2','sans-serif'";
                }elseif($currency_code == 'THB'){
                    // thai font
                    $font_family = "'Kanit','sans-serif'";
                }else{
                    // general for all
                    $font_family = "'Roboto','sans-serif'";
                }

                // $config = ['instanceConfigurator' => function($mpdf) {
                //     $mpdf->showImageErrors = true;
                // }];
                // mpdf config will be used in 4th params of loadview

                $config = [];
                $order = Order::findOrFail($slug);
                if($order){
                    return PDF::loadView('backend.invoices.invoice',[
                        'order' => $order,
                        'font_family' => $font_family,
                        'direction' => $direction,
                        'text_align' => $text_align,
                        'not_text_align' => $not_text_align
                    ], [], $config)->download('order-'.$order->code.'.pdf');
                }else{
                    return redirect('/our_products');
                }

                break;



            default:
            abort(404);
                break;
        }
    }


    public function addrequest(Request $r){
        $data = [
            'name'=>$r->name,
            'contact'=>$r->numbercontact,
            'email'=>$r->email,
            'subject'=>$r->subject,
            'message'=>$r->message,
        ];
        try {
            Patnerrequest::insert($data);
            $msg = "success";
            return $msg;
        } catch (\Throwable $th) {
            return $th->getmessage;
        }
    }


        public function Product($request, $slug)
    {
        $detailedProduct  = Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop')->where('auction_product', 0)->where('slug', $slug)->where('approved', 1)->first();

        $product_queries = ProductQuery::where('product_id', $detailedProduct->id)->where('customer_id', '!=', Auth::id())->latest('id')->paginate(10);
        $total_query = ProductQuery::where('product_id', $detailedProduct->id)->count();
        // Pagination using Ajax
        if (request()->ajax()) {
            return Response::json(View::make('frontend.partials.product_query_pagination', array('product_queries' => $product_queries))->render());
        }
        // End of Pagination using Ajax

        if ($detailedProduct != null && $detailedProduct->published) {
            /*if ($request->has('product_referral_code') && addon_is_activated('affiliate_system')) {
                $affiliate_validation_time = AffiliateConfig::where('type', 'validation_time')->first();
                $cookie_minute = 30 * 24;
                if ($affiliate_validation_time) {
                    $cookie_minute = $affiliate_validation_time->value * 60;
                }
                Cookie::queue('product_referral_code', $request->product_referral_code, $cookie_minute);
                Cookie::queue('referred_product_id', $detailedProduct->id, $cookie_minute);

                $referred_by_user = User::where('referral_code', $request->product_referral_code)->first();

                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
            }*/
            if ($detailedProduct->digital == 1) {
                //return view('frontend.digital_product_details', compact('detailedProduct', 'product_queries', 'total_query'));
            } else {
                return view('acewebfront.pages.detail.detailproductfix', compact('detailedProduct', 'product_queries', 'total_query'));
            }
        }
        abort(404);

    }


    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('frontend.user_login');
    }

    public function registration(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        if ($request->has('referral_code') && addon_is_activated('affiliate_system')) {
            try {
                $affiliate_validation_time = AffiliateConfig::where('type', 'validation_time')->first();
                $cookie_minute = 30 * 24;
                if ($affiliate_validation_time) {
                    $cookie_minute = $affiliate_validation_time->value * 60;
                }

                Cookie::queue('referral_code', $request->referral_code, $cookie_minute);
                $referred_by_user = User::where('referral_code', $request->referral_code)->first();

                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
            } catch (\Exception $e) {
            }
        }
        return view('frontend.user_registration');
    }

    public function cart_login(Request $request)
    {
        $user = null;
        if ($request->get('phone') != null) {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('phone', "+{$request['country_code']}{$request['phone']}")->first();
        } elseif ($request->get('email') != null) {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->first();
        }

        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {
                if ($request->has('remember')) {
                    auth()->login($user, true);
                } else {
                    auth()->login($user, false);
                }
            } else {
                flash(translate('Invalid email or password!'))->warning();
            }
        } else {
            flash(translate('Invalid email or password!'))->warning();
        }
        return back();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (Auth::user()->user_type == 'seller') {
            return redirect()->route('seller.dashboard');
        } elseif (Auth::user()->user_type == 'customer') {
            return view('frontend.user.customer.dashboard');
        } elseif (Auth::user()->user_type == 'delivery_boy') {
            return view('delivery_boys.frontend.dashboard');
        } else {
            abort(404);
        }
    }

    public function profile(Request $request)
    {
        if (Auth::user()->user_type == 'seller') {
            return redirect()->route('seller.profile.index');
        } elseif (Auth::user()->user_type == 'delivery_boy') {
            return view('delivery_boys.frontend.profile');
        } else {
            return view('frontend.user.profile');
        }
    }

    public function userProfileUpdate(Request $request)
    {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if ($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }

        $user->avatar_original = $request->photo;
        $user->save();

        flash(translate('Your Profile has been updated successfully!'))->success();
        return back();
    }

    public function flash_deal_details($slug)
    {
        $flash_deal = FlashDeal::where('slug', $slug)->first();
        if ($flash_deal != null)
            return view('frontend.flash_deal_details', compact('flash_deal'));
        else {
            abort(404);
        }
    }

    public function load_featured_section()
    {
        return view('frontend.partials.featured_products_section');
    }

    public function load_best_selling_section()
    {
        return view('frontend.partials.best_selling_section');
    }

    public function load_auction_products_section()
    {
        if (!addon_is_activated('auction')) {
            return;
        }
        return view('auction.frontend.auction_products_section');
    }

    public function load_home_categories_section()
    {
        return view('frontend.partials.home_categories_section');
    }

    public function load_best_sellers_section()
    {
        return view('frontend.partials.best_sellers_section');
    }

    public function trackOrder(Request $request)
    {
        // print "20230519-17000252";
        if ($request->has('order_code')) {
            $order = Order::where('code', $request->order_code)->first();
            if ($order != null) {
                return view('frontend.track_order', compact('order'));
            }
        }
        return view('frontend.track_order');
    }



    public function shop($slug)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if ($shop != null) {
            if ($shop->verification_status != 0) {
                return view('frontend.seller_shop', compact('shop'));
            } else {
                return view('frontend.seller_shop_without_verification', compact('shop'));
            }
        }
        abort(404);
    }

    public function filter_shop($slug, $type)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if ($shop != null && $type != null) {
            return view('frontend.seller_shop', compact('shop', 'type'));
        }
        abort(404);
    }

    public function all_categories(Request $request)
    {
        $categories = Category::where('level', 0)->orderBy('order_level', 'desc')->get();
        return view('frontend.all_category', compact('categories'));
    }

    public function all_brands(Request $request)
    {
        $categories = Category::all();
        return view('frontend.all_brand', compact('categories'));
    }

    public function home_settings(Request $request)
    {
        return view('home_settings.index');
    }

    public function top_10_settings(Request $request)
    {
        foreach (Category::all() as $key => $category) {
            if (is_array($request->top_categories) && in_array($category->id, $request->top_categories)) {
                $category->top = 1;
                $category->save();
            } else {
                $category->top = 0;
                $category->save();
            }
        }

        foreach (Brand::all() as $key => $brand) {
            if (is_array($request->top_brands) && in_array($brand->id, $request->top_brands)) {
                $brand->top = 1;
                $brand->save();
            } else {
                $brand->top = 0;
                $brand->save();
            }
        }

        flash(translate('Top 10 categories and brands have been updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }

    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;
        $tax = 0;
        $max_limit = 0;

        if ($request->has('color')) {
            $str = $request['color'];
        }

        if (json_decode($product->choice_options) != null) {
            foreach (json_decode($product->choice_options) as $key => $choice) {
                if ($str != null) {
                    $str .= '-' . str_replace(' ', '', $request['attribute_id_' . $choice->attribute_id]);
                } else {
                    $str .= str_replace(' ', '', $request['attribute_id_' . $choice->attribute_id]);
                }
            }
        }

        $product_stock = $product->stocks->where('variant', $str)->first();

        $price = $product_stock->price;


        if ($product->wholesale_product) {
            $wholesalePrice = $product_stock->wholesalePrices->where('min_qty', '<=', $request->quantity)->where('max_qty', '>=', $request->quantity)->first();
            if ($wholesalePrice) {
                $price = $wholesalePrice->price;
            }
        }

        $quantity = $product_stock->qty;
        $max_limit = $product_stock->qty;

        if ($quantity >= 1 && $product->min_qty <= $quantity) {
            $in_stock = 1;
        } else {
            $in_stock = 0;
        }

        //Product Stock Visibility
        if ($product->stock_visibility_state == 'text') {
            if ($quantity >= 1 && $product->min_qty < $quantity) {
                $quantity = translate('In Stock');
            } else {
                $quantity = translate('Out Of Stock');
            }
        }

        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        // taxes
        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }

        $price += $tax;

        return array(
            'price' => single_price($price * $request->quantity),
            'quantity' => $quantity,
            'digital' => $product->digital,
            'variation' => $str,
            'max_limit' => $max_limit,
            'in_stock' => $in_stock
        );
    }

    public function sellerpolicy()
    {
        $page =  Page::where('type', 'seller_policy_page')->first();
        return view("frontend.policies.sellerpolicy", compact('page'));
    }

    public function returnpolicy()
    {
        $page =  Page::where('type', 'return_policy_page')->first();
        return view("frontend.policies.returnpolicy", compact('page'));
    }

    public function supportpolicy()
    {
        $page =  Page::where('type', 'support_policy_page')->first();
        return view("frontend.policies.supportpolicy", compact('page'));
    }

    public function terms()
    {
        $page =  Page::where('type', 'terms_conditions_page')->first();
        return view("frontend.policies.terms", compact('page'));
    }

    public function privacypolicy()
    {
        $page =  Page::where('type', 'privacy_policy_page')->first();
        return view("frontend.policies.privacypolicy", compact('page'));
    }

    public function get_pick_up_points(Request $request)
    {
        $pick_up_points = PickupPoint::all();
        return view('frontend.partials.pick_up_points', compact('pick_up_points'));
    }

    public function get_category_items(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return view('frontend.partials.category_elements', compact('category'));
    }

    public function premium_package_index()
    {
        $customer_packages = CustomerPackage::all();
        return view('frontend.user.customer_packages_lists', compact('customer_packages'));
    }

    // public function new_page()
    // {
    //     $user = User::where('user_type', 'admin')->first();
    //     auth()->login($user);
    //     return redirect()->route('admin.dashboard');

    // }


    // Ajax call
    public function new_verify(Request $request)
    {
        $email = $request->email;
        if (isUnique($email) == '0') {
            $response['status'] = 2;
            $response['message'] = 'Email already exists!';
            return json_encode($response);
        }

        $response = $this->send_email_change_verification_mail($request, $email);
        return json_encode($response);
    }


    // Form request
    public function update_email(Request $request)
    {
        $email = $request->email;
        if (isUnique($email)) {
            $this->send_email_change_verification_mail($request, $email);
            flash(translate('A verification mail has been sent to the mail you provided us with.'))->success();
            return back();
        }

        flash(translate('Email already exists!'))->warning();
        return back();
    }

    public function send_email_change_verification_mail($request, $email)
    {
        $response['status'] = 0;
        $response['message'] = 'Unknown';

        $verification_code = Str::random(32);

        $array['subject'] = 'Email Verification';
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = 'Verify your account';
        $array['link'] = route('email_change.callback') . '?new_email_verificiation_code=' . $verification_code . '&email=' . $email;
        $array['sender'] = Auth::user()->name;
        $array['details'] = "Email Second";

        $user = Auth::user();
        $user->new_email_verificiation_code = $verification_code;
        $user->save();

        try {
            Mail::to($email)->queue(new SecondEmailVerifyMailManager($array));

            $response['status'] = 1;
            $response['message'] = translate("Your verification mail has been Sent to your email.");
        } catch (\Exception $e) {
            // return $e->getMessage();
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function email_change_callback(Request $request)
    {
        if ($request->has('new_email_verificiation_code') && $request->has('email')) {
            $verification_code_of_url_param =  $request->input('new_email_verificiation_code');
            $user = User::where('new_email_verificiation_code', $verification_code_of_url_param)->first();

            if ($user != null) {

                $user->email = $request->input('email');
                $user->new_email_verificiation_code = null;
                $user->save();

                auth()->login($user, true);

                flash(translate('Email Changed successfully'))->success();
                if ($user->user_type == 'seller') {
                    return redirect()->route('seller.dashboard');
                }
                return redirect()->route('dashboard');
            }
        }

        flash(translate('Email was not verified. Please resend your mail!'))->error();
        return redirect()->route('dashboard');
    }

    public function reset_password_with_code(Request $request)
    {

        if (($user = User::where('email', $request->email)->where('verification_code', $request->code)->first()) != null) {
            if ($request->password == $request->password_confirmation) {
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                auth()->login($user, true);

                flash(translate('Password updated successfully'))->success();

                if (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff') {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            } else {
                flash("Password and confirm password didn't match")->warning();
                return view('auth.passwords.reset');
            }
        } else {
            flash("Verification code mismatch")->error();
            return view('auth.passwords.reset');
        }
    }


    public function all_flash_deals()
    {
        $today = strtotime(date('Y-m-d H:i:s'));

        $data['all_flash_deals'] = FlashDeal::where('status', 1)
            ->where('start_date', "<=", $today)
            ->where('end_date', ">", $today)
            ->orderBy('created_at', 'desc')
            ->get();

        return view("frontend.flash_deal.all_flash_deal_list", $data);
    }

    public function all_seller(Request $request)
    {
        $shops = Shop::whereIn('user_id', verified_sellers_id())
            ->paginate(15);

        return view('frontend.shop_listing', compact('shops'));
    }

    public function all_coupons(Request $request)
    {
        $coupons = Coupon::where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->paginate(15);
        return view('frontend.coupons', compact('coupons'));
    }

    public function inhouse_products(Request $request)
    {
        $products = filter_products(Product::where('added_by', 'admin'))->with('taxes')->paginate(12)->appends(request()->query());
        return view('frontend.inhouse_products', compact('products'));
    }
}
