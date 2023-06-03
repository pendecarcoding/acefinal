<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\PolicyCollection;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Pricefeed;
use Session;
class PricefeedController extends Controller
{
    public function update(Request $r)
    {
        $r->validate([
            'timeprice' => 'unique:pricefeeds,created_at',

        ]);
        $ip        = $_SERVER['REMOTE_ADDR'];
        $timeprice = explode(' ',$r->timeprice);
        $currentDateTime = date('Y-m-d H:i:s');
        $currentDate     = date('Y-m-d');
        $isAM = (date('A', strtotime($currentDateTime)) === 'AM');


            if ($isAM) {
                $data =[
                    'updateby'=>'SYSTEM',
                    'name'=>'CRONJOB',
                    'systemprice'=>$r->currentprice,
                    'overrideprice'=>$r->overrideprice,
                    'ip'=>$ip,
                    'created_at'=>$r->timeprice
                ];
                    try {
                        Pricefeed::insert($data);


                    } catch (\Throwable $th) {
                        //throw $th;
                    }

                    $datas = Product::all();
                    foreach ($datas as $key => $v) {
                        $margin = DB::table('marginprice')->where('denominations',$v->weight)->first();
                        $formula = ($r->overrideprice+$margin->margin)*$v->weight;
                        if($v->discount_start_date != null && $v->discount_end_date != null && $v->promo_price != null){
                            $discount  = ($r->overrideprice+$v->promo_price)*$v->weight;
                            $discount  = $formula-$discount;
                            $u = [
                                'unit_price'=>$formula,
                                'discount'=>$discount
                            ];
                            $act = Product::where('id',$v->id)->update($u);
                            $p = [
                                'price'=>$formula
                            ];
                            $act = DB::table('product_stocks')->where('product_id',$v->id)->update($p);
                        }else{
                            $u = [
                                'unit_price'=>$formula
                            ];
                            $act = Product::where('id',$v->id)->update($u);
                            $p = [
                                'price'=>$formula
                            ];
                            $act = DB::table('product_stocks')->where('product_id',$v->id)->update($p);

                        }
                    }
            } else {
                $data =[
                    'updateby'=>'SYSTEM',
                    'name'=>'CRONJOB',
                    'systemprice'=>$r->currentprice,
                    'overrideprice'=>$r->overrideprice,
                    'ip'=>$ip,
                    'created_at'=>$r->timeprice
                ];
                try {
                    Pricefeed::insert($data);


                } catch (\Throwable $th) {
                    //throw $th;
                }
                    $datas = Product::all();
                    foreach ($datas as $key => $v) {
                        $margin = DB::table('marginprice')->where('denominations',$v->weight)->first();
                        $formula = ($r->overrideprice+$margin->margin)*$v->weight;
                        if($v->discount_start_date != null && $v->discount_end_date != null && $v->promo_price != null){
                            $discount  = ($r->overrideprice+$v->promo_price)*$v->weight;
                            $discount  = $formula-$discount;
                            $u = [
                                'unit_price'=>$formula,
                                'discount'=>$discount
                            ];
                            $act = Product::where('id',$v->id)->update($u);
                            $p = [
                                'price'=>$formula
                            ];
                            $act = DB::table('product_stocks')->where('product_id',$v->id)->update($p);
                        }else{
                            $u = [
                                'unit_price'=>$formula
                            ];
                            $act = Product::where('id',$v->id)->update($u);
                            $p = [
                                'price'=>$formula
                            ];
                            $act = DB::table('product_stocks')->where('product_id',$v->id)->update($p);

                        }
                    }
            }



    }





    }

