<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use App\Models\Backend\SubscribeModel;
use App\Models\Backend\TermsModel;
use App\Models\Backend\CountryModel;
use App\Models\Backend\ProvinceModel;
use App\Models\Backend\TourModel;
use App\Models\Backend\TourGroupModel;
use App\Models\Backend\TourTypeModel;
use App\Models\Backend\TourDetailModel;
use App\Models\Backend\TourPeriodModel;
use App\Models\Backend\CalendarModel;
use App\Models\Backend\BookingFormModel;
use App\Models\Backend\CityModel;
use App\Models\Backend\User;
use App\Models\Backend\TravelTypeModel;
use App\Models\Backend\KeywordSearchModel;
use App\Models\Backend\AmupurModel;
use App\Models\Backend\ContactModel;
use App\Models\Backend\TagContentModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\MemberModel;

use DB;
use Session;
use Carbon\Carbon;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function wishlist($id)
    {
        // dd($id,$request);
        $data = array(
            'data' => TermsModel::where('status','on')->orderby('id','asc')->get(),
            'id' => $id,
        );
        return view('frontend.wishlist',$data);
    }
    public function wishlist_country(Request $request)
    {
        // dd($request);
        $likedTourIds = $request->likedTours?$request->likedTours:[];
        $dat = TourModel::whereIn('id',$likedTourIds)->where(['status'=>'on'])->whereNull('deleted_at')->orderby('id','desc')->get();
        $c_id = $request->c_id;
        $country_all = array();
        $province_all = array();
        $id_tour = array();
        $id_tourP = array();
        if($dat){
            foreach($dat as $da){
                if(json_decode($da->country_id,true) != null ){
                    $country_all = array_merge($country_all,json_decode($da->country_id,true));
                    foreach(json_decode($da->country_id,true) as $cid){
                        $id_tour[$cid][] = $da->id;
                        $id_tour[$cid] = array_unique($id_tour[$cid]);
                    }
                }if(json_decode($da->province_id,true) != null)
                    $province_all = array_merge($province_all,json_decode($da->province_id,true));
                    foreach(json_decode($da->province_id,true) as $cid){
                        $id_tourP[$cid][] = $da->id;
                        $id_tourP[$cid] = array_unique($id_tourP[$cid]);
                    }
               
            }
        }
        $country_all = array_unique($country_all);
        $province_all = array_unique($province_all);
        //dd($province_all,$country_all);
        $data = array(
            'data' => $dat,
            'country_all' => $country_all,
            'province_all' => $province_all,
            'c_id' => $c_id,
            'id_tour' => $id_tour,
            'id_tourP' => $id_tourP,
        );
        return view('frontend.wishlist_country',$data);
    }
    public function getLikedTours(Request $request)
    {
        $likedTourIds = $request->likedTours?$request->likedTours:[];
       
        //ฟิลเตอร์ประเทศ
        $country_id = $request->c_id;
        
        $dat = TourModel::whereIn('id',$likedTourIds)
        ->when($country_id, function ($query) use ($country_id){
                if ($country_id) {
                    $query->where('country_id', 'like', '%"' . $country_id . '"%');
                    $query->orWhere('province_id', 'like', '%"' . $country_id . '"%');
                }
            })
        ->where(['status'=>'on'])->whereNull('deleted_at')->orderby('id','desc')->get();
        //dd($likedTourIds,$dat);
        $data_like = TourModel::whereIn('id',$likedTourIds)->where(['status'=>'on'])->whereNull('deleted_at')->orderby('id','desc')->get(); // ทัวร์ที่แสดงอยู่

        $likedTourIds = array_map('intval', $likedTourIds);
        $invalidIds = array_diff($likedTourIds, $data_like->pluck('id')->toArray());
           
        $c = array();
        foreach($dat as $d){
            $c[] = $d->id;
        }

        $period = TourPeriodModel::whereIn('tour_id',$c)->where('status_display','on')->whereDate('start_date','>=',now())->whereNull('deleted_at')->get();
        
        $calendar = null;
        if($period){
            $min = $period->min('start_date');
            $max = $period->max('start_date');
            $datenow = '2023-07-11';
            if($min && $max){
                // $calendar = CalendarModel::whereYear('start_date','>=',date('Y',strtotime($min)))
                // ->whereMonth('start_date','>=',date('m',strtotime($min)))
                // ->whereDate('start_date','<=',$max)
                // ->where('status','on')
                // ->whereNull('deleted_at')
                // ->get();
                $calendar = CalendarModel::whereDate('start_date','>=',now())
                ->where('status','on')
                ->whereNull('deleted_at')
                ->get();
            }else{
                $calendar = null;
            }
        }

        if($calendar){
            $arr = array();
            foreach($calendar as $calen){
                $start = strtotime($calen->start_date);
                while ($start <= strtotime($calen->end_date)) {
                    $arr[] = date('Y-m-d',$start);
                    $start = $start + 86400;
                }
            }
        }else{
            $arr = null;
        }
        $data = array(
            'data' => $dat,
            'arr' => $arr,
            'invalidIds' => $invalidIds,
        );
        return view('frontend.wishlist_tour',$data);
    }

    public function subscribe(Request $request)
    {
        try {
            DB::beginTransaction();
            $email = SubscribeModel::where('email',$request->email)->first();
            if(!$email){
                $lastRecord = SubscribeModel::latest()->first();
                if(!$lastRecord || now()->diffInSeconds($lastRecord->created_at) > 10){
                    $data = new SubscribeModel;
                    $data->email = $request->email;
                    if ($data->save()) {
                        DB::commit();
                        return back()->with(['success' => 'บันทึกข้อมูลเรียบร้อย']);
                    } else {
                        return back()->with(['error' => 'เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง!!']);
                    }
                }else{
                    return back()->with(['error' => 'เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง!!']);
                }

            }else{
                return back()->with(['error' => 'เกิดข้อผิดพลาด อีเมลนี้มีในระบบแล้ว!!']);
            }
            

        } catch (Exception $e) {
            \DB::rollback();
            dd($e->getMessage());
        }
    }

    public function policy()
    {
        $data = array(
            'data' => TermsModel::where('status','on')->orderby('id','asc')->get(),
        );
        return view('frontend.policy',$data);
    }

    // public function filter_oversea(Request $request)
    // {
    //     $tour_id = json_decode($request->tour_id,true);
    //     $calendar = json_decode($request->calen_id,true);
    //     $orderby_data = '';
    //     $pe_data = TourPeriodModel::leftjoin('tb_tour','tb_tour_period.tour_id','=','tb_tour.id')->whereNull('tb_tour.deleted_at');
    //     if($tour_id){
    //         $pe_data =  $pe_data->whereIn('tb_tour.id',$tour_id); 
    //     }
    //     // $calen = array(); 
    //     // if($request->slug){
    //     //     $pe_data = $pe_data->where('tb_tour.slug','like','%"'.$request->slug.'"%');
    //     // }
       
    //     if($request->data){
    //         if(isset($request->data['day'])){
    //             $pe_data = $pe_data->whereIn('tb_tour_period.day',$request->data['day']);
    //         }
    //         if(isset($request->data['price'])){
    //             $pe_data = $pe_data->whereIn('tb_tour.price_group',$request->data['price']);
    //         }
    //         if(isset($request->data['airline'])){
    //             $pe_data = $pe_data->whereIn('tb_tour.airline_id',$request->data['airline']);
    //         }
            
    //         if(isset($request->data['rating'])){
    //             if(!in_array(0,$request->data['rating'])){
    //                 $pe_data = $pe_data->whereIn('tb_tour.rating',$request->data['rating']);
    //             }else{
    //                 $pe_data = $pe_data->whereNull('tb_tour.rating');
    //             }
    //         }
    //         // dd($pe_data->get(),$request->data['rating']);
    //         if(isset($request->data['month_fil'])){
    //             $pe_data = $pe_data->whereIn('tb_tour_period.group_date',$request->data['month_fil']);
    //         }
    //         if(isset($request->data['calen_start'])){
    //             if($calendar){
    //                 foreach($calendar as $c => $calen_date){
    //                     if(in_array($c,$request->data['calen_start'])){
    //                     }else{
    //                         unset($calendar[$c]);
    //                     }
    //                 }
    //             }
                
    //         }
    //     }
    //     if($request->orderby){
    //         $orderby_data = $request->orderby;
    //         // ราคาถูกสุด
    //          if($request->orderby == 1){
    //             $pe_data = $pe_data->orderby('tb_tour.price','asc');
    //         }
    //         // ยอดวิวเยอะสุด
    //         if($request->orderby == 2){
    //             $pe_data = $pe_data->orderby('tb_tour.tour_views','desc');
    //         }
    //         // ลดราคา
    //         if($request->orderby == 3){
    //             $pe_data = $pe_data->where('tb_tour.special_price','>',0)->orderby('tb_tour.special_price','desc');
    //         }
    //         // โปรโมชั่น
    //         if($request->orderby == 4){
    //             $pe_data = $pe_data->whereNotNull('tb_tour_period.promotion_id')->whereDate('tb_tour_period.pro_start_date','<=',date('Y-m-d'))->whereDate('tb_tour_period.pro_end_date','>=',date('Y-m-d'));
    //         }
    //     }
    //     if($request->start_date && $request->end_date){
    //         if($request->start_date){
    //             $pe_data = $pe_data->whereDate('tb_tour_period.start_date','>=',$request->start_date);
    //         }if($request->end_date){
    //             $pe_data = $pe_data->whereDate('tb_tour_period.end_date','<=',$request->end_date);
    //         }
    //     }else{
    //         $pe_data = $pe_data->whereDate('tb_tour_period.start_date','>=',now());
    //     }
    //     // if($request->start_date){
    //     //     $pe_data = $pe_data->whereDate('tb_tour_period.start_date','>=',$request->start_date);
    //     // }if($request->end_date){
    //     //     $pe_data = $pe_data->whereDate('tb_tour_period.end_date','<=',$request->end_date);
    //     // }
    //     // // if($request->start_date_mb ){
    //     // //     $pe_data = $pe_data->whereDate('tb_tour_period.start_date','>=',$request->start_date_mb);
    //     // // }if($request->end_date_mb){
    //     // //     $pe_data = $pe_data->whereDate('tb_tour_period.start_date','<=',$request->end_date_mb);
    //     // // }
    //     // else{
    //     //     $pe_data = $pe_data->whereDate('tb_tour_period.start_date','>=',now());
    //     // }
    //     $pe_data = $pe_data->where('tb_tour.status','on')
    //         ->where('tb_tour_period.status_display','on')
    //         ->orderby('tb_tour_period.start_date','asc')
    //         ->orderby('tb_tour.rating','desc')
    //         ->select('tb_tour_period.*')
    //         ->get();
      
    //     if(isset($request->data['calen_start']) && $calendar){    
    //         $id_pe = array();
    //         foreach($pe_data as $da){
    //             $check_test = false;
    //             foreach($calendar as $cid => $calen){
    //                 $start_pe = strtotime($da->start_date);
    //                 while ($start_pe <= strtotime($da->end_date)) {
    //                     if(in_array(date('Y-m-d',$start_pe),$calen)){
    //                         $check_test = true;
    //                         break;
    //                     }
    //                     $start_pe = $start_pe + 86400;
    //                 }
    //             }
    //             if($check_test){
    //                 $id_pe[] = $da->id;
    //             }
    //         }
    //         $pe_data = TourPeriodModel::leftjoin('tb_tour','tb_tour_period.tour_id','=','tb_tour.id')->whereIn('tb_tour_period.id',$id_pe)
    //         ->orderby('tb_tour_period.start_date','asc')
    //         ->orderby('tb_tour.rating','desc')
    //         ->select('tb_tour_period.*')
    //         ->get()
    //         ->groupBy('tour_id');
    //     }else{
    //         $pe_data = $pe_data->groupBy('tour_id');
    //     }
    //     $period = array();
    //     foreach($pe_data as $k => $pe){
    //         $period[$k]['period']  = $pe;
    //         $period[$k]['recomand'] = TourPeriodModel::where('tour_id',$k)
    //         ->where('status_display','on')->where('deleted_at',null)
    //         ->orderby('start_date','asc')
    //         ->limit(2)->get()->groupBy('group_date');
    //         $period[$k]['soldout'] = TourPeriodModel::where('tour_id',$k);
    //         if($request->data){
    //             if(isset($request->data['start_date'])){
    //                 $period[$k]['soldout'] = $period[$k]['soldout']->whereDate('start_date','>=',$request->data['start_date']);
    //             }
    //             if(isset($request->data['end_date'])){
    //                 $period[$k]['soldout'] = $period[$k]['soldout']->whereDate('start_date','<=',$request->data['end_date']);
    //             }
    //         }
    //         // ->whereDate('start_date','>=',$dat->start_date)
    //         // ->whereDate('start_date','<=',$dat->end_date)
    //         $period[$k]['soldout'] = $period[$k]['soldout']->where('status_period',3)->where('status_display','on')
    //         ->where('deleted_at',null)
    //         ->orderby('start_date','asc')
    //         ->get()->groupBy('group_date');
    //         $tour = TourModel::find($k);
    //         $period[$k]['tour'] = $tour;
    //     }
    //     $filter = array();
    //     foreach($period as $i => $per){
    //         if(isset($request->data['country'])){
    //             if(count(array_intersect($request->data['country'],$per['country_id'])) != count($request->data['country'])){
    //                 unset($period[$i]);
    //             }
    //         }
    //         if(isset($request->data['city'])){
    //             if(count(array_intersect($request->data['city'],$per['city_id'])) != count($request->data['city'])){
    //                 unset($period[$i]);
    //             }
    //         }
    //        if(isset($period[$i])){
    //             //ช่วงราคา
    //             if(isset($filter['price'][$per['tour']->price_group])){
    //                 if(!in_array($per['tour']->id,$filter['price'][$per['tour']->price_group])){
    //                     $filter['price'][$per['tour']->price_group][] = $per['tour']->id;
    //                 }
    //             }else{
    //                 $filter['price'][$per['tour']->price_group][] = $per['tour']->id;
    //             }
    //             //จำนวนวัน
    //             foreach($per['period']  as $p){
    //                 // dd($per['period'] );
    //                 if($p->day){
    //                     if(isset($filter['day'][$p->day])){
    //                         if(!in_array($per['tour']->id,$filter['day'][$p->day])){
    //                             $filter['day'][$p->day][] = $per['tour']->id;
    //                         }
    //                     }else{
    //                         $filter['day'][$p->day][] = $per['tour']->id;
    //                     }
    //                 }
    //                 if($p->start_date){
    //                     //ช่วงเดือน
    //                     $month_start = date('n',strtotime($p->start_date));
    //                     //ช่วงเดือน-ปี
    //                     $year_start = date('Y',strtotime($p->start_date));
    //                     if(isset($filter['year'][$year_start][$month_start])){
    //                         if(!in_array($per['tour']->id,$filter['year'][$year_start][$month_start])){
    //                             $filter['year'][$year_start][$month_start][] = $per['tour']->id;
    //                         }
    //                     }else{
    //                         $filter['year'][$year_start][$month_start][] = $per['tour']->id;
    //                     }
                        
    //                 }
    //                 //วันหยุดเทศกาล
    //                 if($calendar){
    //                     foreach($calendar as $cid => $calen){
    //                         $start_pe = strtotime($p->start_date);
    //                         while ($start_pe <= strtotime($p->end_date)) {
    //                             // echo date('Y-m-d',$start_pe).$tour->tour_id."<br>";
    //                             if(in_array(date('Y-m-d',$start_pe),$calen)){
    //                                 // dd($p);
    //                                 if(isset($filter['calendar'][$cid])){
    //                                     if(!in_array($p->tour_id,$filter['calendar'][$cid])){
    //                                             $filter['calendar'][$cid][] = $p->tour_id;
    //                                         }
    //                                     }else{
    //                                         $filter['calendar'][$cid][] = $p->tour_id;
    //                                     }
    //                             }
    //                             $start_pe = $start_pe + 86400;
    //                         }
    //                     }
    //                 }
                    
    //             }
    //             //ประเทศ
    //             if($per['tour']->country_id){
    //                 if(isset($filter['country'])){
    //                     $filter['country'] = array_merge($filter['country'],json_decode($per['tour']->country_id,true));
    //                     $filter['country'] = array_unique($filter['country']);
    //                 }else{
    //                     $filter['country'] = json_decode($per['tour']->country_id,true);
    //                 }
    //             }
    //             //เมือง
    //             if($per['tour']->city_id){
    //                 if(isset($filter['city'])){
    //                     $filter['city'] = array_merge($filter['city'],json_decode($per['tour']->city_id,true));
    //                     $filter['city'] = array_unique($filter['city']);
    //                 }else{
    //                     $filter['city'] = json_decode($per['tour']->city_id,true);
    //                 }
    //             }
    //             //สายการบิน
    //              if($per['tour']->airline_id){
    //                 $filter['airline'][$per['tour']->airline_id][] = $per['tour']->id;
    //             }
               
    //             //ดาว
    //             $filter['rating'][$per['tour']->rating][] = $per['tour']->rating ;
                   
    //        }
    //     }

    //     // dd($filter,$request->data);
    //     $num_price = 0;
    //     if(isset($filter['price'])){
    //         foreach($filter['price'] as $p){
    //             $num_price =  $num_price + count($p);
    //         }
    //     }
      
    //     $row = TourPeriodModel::leftjoin('tb_tour','tb_tour_period.tour_id','=','tb_tour.id');
    //     if($request->data){
    //         if(isset($request->data['start_date'])){
    //             $row = $row->whereDate('tb_tour_period.start_date','>=',$request->data['start_date']);
    //         }
    //         if(isset($request->data['end_date'])){
    //             $row = $row ->whereDate('tb_tour_period.start_date','<=',$request->data['end_date']);
    //         }
    //     }
        
    //     $row = $row->where('tb_tour.status','on')
    //     ->where('tb_tour_period.status_display','on')
    //     ->orderby('tb_tour_period.start_date','asc')
    //     ->select('tb_tour_period.*')
    //     ->get()
    //     ->groupBy('tour_id');

    //     $count_pe = count($period);
       
    //     $data = array(
    //         // 'data' => $dat,
    //         'period' => $period,
    //         'calen_id' => $request->id,
    //         'slug' => $request,
    //         'row' => $row,
    //         'filter' => $filter,
    //         'airline_data' => TravelTypeModel::/* where('status','on')-> */where('deleted_at',null)->get(),
    //         'num_price' => $num_price,
    //         'tour_list' => $this->search_filter($request,$period),
    //         'tour_grid' => $this->search_filter_grid($request,$period),
    //         'count_pe' => $count_pe,
    //         'orderby_data' => $orderby_data,
    //     );
    //     return response()->json($data);
       
    // }

    public function oversea(Request $request,$main_slug)
    {
        try {
            if(!$request->_token){
                Session::put($main_slug,null);
            }
            if(Session::get($main_slug)){
                // dd(Session::get($main_slug));
                return view('frontend.oversea',Session::get($main_slug));
            }else{
                // Platform check 
                $isWin = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "windows"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "windows")):0; 
                $isMac = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "macintosh"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "macintosh")):0; 
                $isAndroid = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "android"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "android")):0; 
                $isIPhone = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone")):0; 
                $isIPad = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "ipad"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "ipad")):0; 
                $country = CountryModel::where('slug',$main_slug)->whereNull('deleted_at')->first();
                $data = array(
                    'country_search' => $country->id,
                    'banner'        => $country->banner,
                    'banner_detail' => $country->banner_detail,
                    'isWin' => $isWin,
                    'isMac' => $isMac,
                    'isAndroid' => $isAndroid,
                    'isIPhone' => $isIPhone,
                    'isIPad' => $isIPad,
                );
                return view('frontend.oversea',$data);
            }
           
           
        } catch (\Throwable $th) {
            // dd($th);
        }
        
    }


    public function inthai(Request $request,$main_slug)
    {
        try {
            // Platform check 
            $isWin = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "windows"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "windows")):0; 
            $isMac = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "macintosh"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "macintosh")):0; 
            $isAndroid = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "android"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "android")):0; 
            $isIPhone = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone")):0; 
            $isIPad = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "ipad"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "ipad")):0; 
            $country = ProvinceModel::where('slug',$main_slug)->whereNull('deleted_at')->first();
            $data = array(
                    'country_search' => $country->id,
                    'banner'        => $country->banner,
                    'banner_detail' => $country->banner_detail,
                    'isWin' => $isWin,
                    'isMac' => $isMac,
                    'isAndroid' => $isAndroid,
                    'isIPhone' => $isIPhone,
                    'isIPad' => $isIPad,
            );
            return view('frontend.inthai',$data);
        } catch (\Throwable $th) {
            // dd($th);
        }
        
    }

    public function search_total(Request $request){
        $country_id = null;
        $city_id = null;
        $travel_id = array();
        $keyword_search = null;
        $tour_code = array();
        $tour_code1 = array();
        $slug_country = null;
        $banner_country = null;
        $detail_country = null;
        $tag_search = null;
        $tag_name = null;
        $code_id = null;

        if($request->search_data){
            // ค้นหาประเทศแบบเร็ว
            $country = CountryModel::where('country_name_th', 'like', "%{$request->search_data}%")
                ->orWhere('country_name_en', 'like', "%{$request->search_data}%")
                ->first();
            if($country){
                $country->count_search = $country->count_search+1;
                $country->save();
                $country_id = $country->id;
                $slug_country = $country->slug;
                $banner_country = $country->banner;
                $detail_country = $country->banner_detail;
            }

            // ค้นหาเมืองแบบเร็ว
            $city = CityModel::where('city_name_th', 'like', "%{$request->search_data}%")
                ->orWhere('city_name_en', 'like', "%{$request->search_data}%")
                ->first();
            if($city){
                $city->count_search = $city->count_search+1;
                $city->save();
                $city_id = $city->id;
            }

            // keyword search
            $keyword = KeywordSearchModel::where('keyword',$request->search_data)->first();
            if($keyword){
                $keyword->count_search = $keyword->count_search + 1;
                $keyword->save();
            }else{
                $keyword_new = new KeywordSearchModel ();
                $keyword_new->keyword = $request->search_data;
                $keyword_new->count_search = 1;
                $keyword_new->save();
            }

            // ถ้าไม่เจอประเทศและเมือง ให้ค้นหาสถานที่ท่องเที่ยว
            if($country_id == null && $city_id == null){
                $keyword_search = $request->search_data;
                $travel = TourModel::where('travel', 'like', "%{$request->search_data}%")->pluck('id')->toArray();
                $travel_id = array_unique($travel);
            }
        }

        if($request->code_tour){
            $code_id = $request->code_tour;
            $tour = TourModel::where('code', 'like', "%{$request->code_tour}%")
                ->orWhere('code1', 'like', "%{$request->code_tour}%")
                ->get();
            foreach($tour as $row){
                if(stristr($row->code,$request->code_tour)){
                    $tour_code[] = $row->id;
                }
                if(!empty($row->code1) && $row->code1 == $request->code_tour){
                    $tour_code1[] = $row->id;
                }
            }
        }
        if($request->tag){
            $tag_search = $request->tag;
            $tag_data = TagContentModel::find($request->tag);
            $tag_name = $tag_data->tag;
        }
        //dd($request);
        // Platform check 
        $isWin = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "windows"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "windows")):0; 
        $isMac = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "macintosh"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "macintosh")):0; 
        $isAndroid = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "android"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "android")):0; 
        $isIPhone = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone")):0; 
        $isIPad = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "ipad"))?is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "ipad")):0; 
        $data = [
            'price_search' => $request->price,
            'country_search' => $country_id,
            'city_search' => $city_id,
            'travel_search' => $travel_id,
            'keyword_search' => $keyword_search,
            'tour_code' => $tour_code?$tour_code:$tour_code1,
            'code_id' => $code_id,
            'start_search' => $request->start_date,
            'end_search' => $request->end_date,
            'str_start' => $request->start_date?strtotime($request->start_date):0,
            'str_end' => $request->end_date?strtotime($request->end_date):0,
            'banner' => $banner_country,
            'banner_detail' => $detail_country,
            'isWin' => $isWin,
            'isMac' => $isMac,
            'isAndroid' => $isAndroid,
            'isIPhone' => $isIPhone,
            'isIPad' => $isIPad,
            'tag_search' => $tag_search,
            'tag_name' => $tag_name,
        ];
        if($country_id != null){
            Session::put($slug_country,$data);
            return redirect("/oversea/$slug_country?_token=".$request->_token);
        }
        return view('frontend.search-result',$data);
    }
    public function clear_search(Request $request){
       $request->session()->invalidate();
       return response()->json(true);
    }
    public function filter_search(Request $request)
    {
        $travel_id = json_decode($request->travel_id,true);
        $tour_id = json_decode($request->tour_id,true);
        $calendar = json_decode($request->calen_id,true);
        $orderby_data = '';
        $pe_data = TourPeriodModel::leftjoin('tb_tour','tb_tour_period.tour_id','=','tb_tour.id')->whereNull('tb_tour.deleted_at')/* ->whereIn('tb_tour.id',$tour_id) */; 
        if($travel_id){
            $pe_data = $pe_data->whereIn('tb_tour.id',$travel_id);
        }
        if($request->data){
            if(isset($request->data['day'])){
                $pe_data = $pe_data->whereIn('tb_tour_period.day',$request->data['day']);
            }
            if(isset($request->data['price'])){
                $pe_data = $pe_data->whereIn('tb_tour.price_group',$request->data['price']);
            }
            if(isset($request->data['airline'])){
                $pe_data = $pe_data->whereIn('tb_tour.airline_id',$request->data['airline']);
            }
            if(isset($request->data['rating'])){
                if(!in_array(0,$request->data['rating'])){
                    $pe_data = $pe_data->whereIn('tb_tour.rating',$request->data['rating']);
                }else{
                    $pe_data = $pe_data->whereNull('tb_tour.rating');
                }
            }if(isset($request->data['month_fil'])){
                $pe_data = $pe_data->whereIn('tb_tour_period.group_date',$request->data['month_fil']);
            }
            if(isset($request->data['calen_start'])){
                if($calendar){
                    foreach($calendar as $c => $calen_date){
                        if(in_array($c,$request->data['calen_start'])){
                        }else{
                            unset($calendar[$c]);
                        }
                    }
                } 
            }
        }
        if($request->orderby){
            $orderby_data = $request->orderby;
            // ราคาถูกสุด
             if($request->orderby == 1){
                $pe_data = $pe_data->orderby('tb_tour.price','asc');
            }
            // ยอดวิวเยอะสุด
            if($request->orderby == 2){
                $pe_data = $pe_data->orderby('tb_tour.tour_views','desc');
            }
            // ลดราคา
            if($request->orderby == 3){
                $pe_data = $pe_data->where('tb_tour.special_price','>',0)->orderby('tb_tour.special_price','desc');
            }
            // โปรโมชั่น
            if($request->orderby == 4){
                $pe_data = $pe_data->whereNotNull('tb_tour_period.promotion_id')->whereDate('tb_tour_period.pro_start_date','<=',date('Y-m-d'))->whereDate('tb_tour_period.pro_end_date','>=',date('Y-m-d'));
            }
        }
        if($request->start_date || $request->end_date){
            if($request->start_date){
                $pe_data = $pe_data->whereDate('tb_tour_period.start_date','>=',$request->start_date);
            }
            if($request->end_date){
                $pe_data = $pe_data->whereDate('tb_tour_period.start_date','<=',$request->end_date);
            }else{
                $pe_data = $pe_data->whereDate('tb_tour_period.start_date','>=',now());
            }
        }else{
            $pe_data = $pe_data->whereDate('tb_tour_period.start_date','>=',now());
            
        }
        $pe_data = $pe_data->where('tb_tour.status','on')
            ->where('tb_tour_period.status_display','on')
            ->orderby('tb_tour_period.start_date','asc')
            ->orderby('tb_tour.rating','desc')
            ->select('tb_tour_period.*')
            ->get();
       
        // dd($pe_data->count());
        if(isset($request->data['calen_start']) && $calendar){    
            $id_pe = array();
            foreach($pe_data as $da){
                $check_test = false;
                foreach($calendar as $cid => $calen){
                    $start_pe = strtotime($da->start_date);
                    while ($start_pe <= strtotime($da->end_date)) {
                        if(in_array(date('Y-m-d',$start_pe),$calen)){
                            $check_test = true;
                            break;
                        }
                        $start_pe = $start_pe + 86400;
                    }
                }
                if($check_test){
                    $id_pe[] = $da->id;
                }
            } $pe_data = TourPeriodModel::leftjoin('tb_tour','tb_tour_period.tour_id','=','tb_tour.id')->whereIn('tb_tour_period.id',$id_pe)
            ->orderby('tb_tour_period.start_date','asc')
            ->orderby('tb_tour.rating','desc')
            ->select('tb_tour_period.*')
            ->get()
            ->groupBy('tour_id');
        }else{
            $pe_data = $pe_data->groupBy('tour_id');
        }
        // dd($pe_data);
        $period = array();
        foreach($pe_data as $k => $pe){
            $period[$k]['period']  = $pe;
            $period[$k]['recomand'] = TourPeriodModel::where('tour_id',$k)
            ->where('status_display','on')->where('deleted_at',null)
            ->orderby('start_date','asc')
            ->limit(2)->get()->groupBy('group_date');
            $period[$k]['soldout'] = TourPeriodModel::where('tour_id',$k);
            if($request->data){
                if(isset($request->data['start_date'])){
                    $period[$k]['soldout'] = $period[$k]['soldout']->whereDate('start_date','>=',$request->data['start_date']);
                }
                if(isset($request->data['end_date'])){
                    $period[$k]['soldout'] = $period[$k]['soldout']->whereDate('start_date','<=',$request->data['end_date']);
                }
            }
            // ->whereDate('start_date','>=',$dat->start_date)
            // ->whereDate('start_date','<=',$dat->end_date)
            $period[$k]['soldout'] = $period[$k]['soldout']->where('status_period',3)->where('status_display','on')
            ->where('deleted_at',null)
            ->orderby('start_date','asc')
            ->get()->groupBy('group_date');
            $tour = TourModel::find($k);
            $period[$k]['tour'] = $tour;
        }
        $filter = array();
        foreach($period as $i => $per){
            if(isset($request->data['country'])){
               
                if(count(array_intersect($request->data['country'],$per['country_id'])) != count($request->data['country'])){
                    // dd($per['country_id'],$i,$period[$i]);
                    unset($period[$i]);
                }
            }
            if(isset($request->data['city'])){
                if(count(array_intersect($request->data['city'],$per['city_id'])) != count($request->data['city'])){
                    unset($period[$i]);
                }
            }
           if(isset($period[$i])){
                //ช่วงราคา
                if(isset($filter['price'][$per['tour']->price_group])){
                    if(!in_array($per['tour']->id,$filter['price'][$per['tour']->price_group])){
                        $filter['price'][$per['tour']->price_group][] = $per['tour']->id;
                    }
                }else{
                    $filter['price'][$per['tour']->price_group][] = $per['tour']->id;
                }
                //จำนวนวัน
                foreach($per['period']  as $p){
                    if($p->day){
                        if(isset($filter['day'][$p->day])){
                            if(!in_array($per['tour']->id,$filter['day'][$p->day])){
                                $filter['day'][$p->day][] = $per['tour']->id;
                            }
                        }else{
                            $filter['day'][$p->day][] = $per['tour']->id;
                        }
                    }
                    if($p->start_date){
                        //ช่วงเดือน
                        $month_start = date('n',strtotime($p->start_date));
                        //ช่วงเดือน-ปี
                        $year_start = date('Y',strtotime($p->start_date));
                        if(isset($filter['year'][$year_start][$month_start])){
                            if(!in_array($per['tour']->id,$filter['year'][$year_start][$month_start])){
                                $filter['year'][$year_start][$month_start][] = $per['tour']->id;
                            }
                        }else{
                            $filter['year'][$year_start][$month_start][] = $per['tour']->id;
                        }
                        //วันหยุดเทศกาล
                        if($calendar){
                            foreach($calendar as $cid => $calen){
                                $start_pe = strtotime($p->start_date);
                                while ($start_pe <= strtotime($p->end_date)) {
                                    if(in_array(date('Y-m-d',$start_pe),$calen)){
                                        if(isset($filter['calendar'][$cid])){
                                            if(!in_array($p->tour_id,$filter['calendar'][$cid])){
                                                    $filter['calendar'][$cid][] = $p->tour_id;
                                                }
                                            }else{
                                                $filter['calendar'][$cid][] = $p->tour_id;
                                            }
                                    }
                                    $start_pe = $start_pe + 86400;
                                }
                            }
                        }
                    }
                }
                //ประเทศ
                if($per['tour']->country_id){
                    if(isset($filter['country'])){
                        $filter['country'] = array_merge($filter['country'],json_decode($per['tour']->country_id,true));
                        $filter['country'] = array_unique($filter['country']);
                    }else{
                        $filter['country'] = json_decode($per['tour']->country_id,true);
                    }
                }
                //เมือง
                if($per['tour']->city_id){
                    if(isset($filter['city'])){
                        $filter['city'] = array_merge($filter['city'],json_decode($per['tour']->city_id,true));
                        $filter['city'] = array_unique($filter['city']);
                    }else{
                        $filter['city'] = json_decode($per['tour']->city_id,true);
                    }
                }
                //สายการบิน
                 if($per['tour']->airline_id){
                    $filter['airline'][$per['tour']->airline_id][] = $per['tour']->id;
                }
               
                //ดาว
                $filter['rating'][$per['tour']->rating][] = $per['tour']->rating ;
                   
           }
        }
        // dd($filter,$request->data);
        $num_price = 0;
        if(isset($filter['price'])){
            foreach($filter['price'] as $p){
                $num_price =  $num_price + count($p);
            }
        }
      
        $row = TourPeriodModel::leftjoin('tb_tour','tb_tour_period.tour_id','=','tb_tour.id');
        if($request->data){
            if(isset($request->data['start_date'])){
                $row = $row->whereDate('tb_tour_period.start_date','>=',$request->data['start_date']);
            }
            if(isset($request->data['end_date'])){
                $row = $row ->whereDate('tb_tour_period.start_date','<=',$request->data['end_date']);
            }
        }
        
        $row = $row->where('tb_tour.status','on')
        ->where('tb_tour_period.status_display','on')
        ->orderby('tb_tour_period.start_date','asc')
        ->select('tb_tour_period.*')
        ->get()
        ->groupBy('tour_id');
        // dd($period);
        $count_pe = count($period);
        $data = array(
            // 'data' => $dat,
            'period' => $period,
            'calen_id' => $request->calen_id,
            'slug' => $request,
            'row' => $row,
            'filter' => $filter,
            'airline_data' => TravelTypeModel::/* where('status','on')-> */where('deleted_at',null)->get(),
            'num_price' => $num_price,
            'tour_list' => $this->search_filter($request,$period),
            'tour_grid' => $this->search_filter_grid($request,$period),
            'count_pe' => $count_pe,
            'orderby_data' => $orderby_data,
        );
        return response()->json($data);
       
    }

    public function recordPageView(Request $request)
    {
        $dat = TourModel::find($request->id);
        if($dat){
            $dat->increment('tour_views');
        }

        // เก็บยอด views ประเทศ
        $country = CountryModel::whereIn('id',json_decode(@$dat->country_id,true))->get();
        if(count($country) > 0){
            foreach($country as $co){
                $co->increment('country_views');
            }
        }

    }

    public function tour_detail($detail_slug)
    {
        $dat = TourModel::where('slug',$detail_slug)->whereNull('deleted_at')->first();
        $period = TourPeriodModel::where(['tour_id'=>$dat->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->whereNull('deleted_at')->get();
        $min = $period->min('start_date');
        $max = $period->max('start_date');
        $datenow = '2023-07-11';
        if($min && $max){
            $calendar = CalendarModel::whereYear('start_date','>=',date('Y',strtotime($min)))
            ->whereMonth('start_date','>=',date('m',strtotime($min)))
            ->whereDate('start_date','<=',$max)
            ->where('status','on')
            ->whereNull('deleted_at')
            ->get();
        }else{
            $calendar = null;
        }

        if($calendar){
            $arr = array();
            foreach($calendar as $calen){
                $start = strtotime($calen->start_date);
                while ($start <= strtotime($calen->end_date)) {
                    $arr[] = date('Y-m-d',$start);
                    $start = $start + 86400;
                }
            }
        }else{
            $arr = null;
        }
        $data = array(
            'data' => $dat,
            'arr' => $arr,
            'detail_slug' => $detail_slug,
        );
        return view('frontend.tour_detail',$data);
    }

    public function tour_summary($detail_slug,$id)
    {

        Session::forget('booking');
        Session::forget('tour');

        $dat = TourModel::where('slug',$detail_slug)->whereNull('deleted_at')->first();

        $periods = TourPeriodModel::where(['tour_id'=>$dat->id,'status_display'=>'on','status_period'=>1])->whereDate('start_date','>=',now())->whereNull('deleted_at')->orderby('start_date','asc')->get();

        $period = TourPeriodModel::find($id);

        $sales = User::where(['role'=>2,'status'=>'active'])->get();
        
        $data = array(
            'data' => $dat,
            'periods' => $periods,
            'period' => $period,
            'sales' => $sales,
            'period_id' => $id,
        );
        return view('frontend.tour_summary',$data);
    }

    public function loadPrice(Request $request)
    {
        $period = TourPeriodModel::find($request->id);
        if(@$period->special_price1 > 0){
            $price1 = @$period->price1 - @$period->special_price1;
        }else{
            $price1 = @$period->price1;
        }

        if($period->special_price2 > 0){
            $orignal_price = $period->price1 + $period->price2; // เอาพักเดี่ยวบวกพักคู่ จะได้ราคาจริง
            $price2 = $orignal_price - $period->special_price2; // เอาราคาที่บวกแล้วมาลบส่วนลด
        }else{
            $price2 = $period->price1 + $period->price2;
        }

        if($period->special_price3 > 0){
            $price3 = $period->price3 - $period->special_price3;
        }else{
            $price3 = $period->price3;
        }

        if($period->special_price4 > 0){
            $price4 = $period->price4 - $period->special_price4;
        }else{
            $price4 = $period->price4;
        }

        $count = $period->count;

        if($period){
            $arr = [
                'status' => '200',
                'result' => 'success',
                'price1' => $price1,
                'price2' => $price2,
                'price3' => $price3,
                'price4' => $price4,
                'count' => $count,
                'message' => 'ดำเนินการสำเร็จ'
            ];
        }else{
            $arr = [
                'status' => '500',
                'result' => 'error',
                'price1' => 0,
                'price2' => 0,
                'price3' => 0,
                'price4' => 0,
                'count' => 0,
                'message' => 'เกิดข้อผิดพลาด'
            ];
        }
        return response()->json($arr);
    }

    public function booking(Request $request){
        //dd($request->all());
        DB::beginTransaction();
        try {
            $recaptcha = $request['g-recaptcha-response'];
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=6LdQYyIqAAAAAGFTw3OBhEZwsete72cClVP705o_&response=' . $recaptcha . '&remoteip=' . $_SERVER['REMOTE_ADDR'];
            // $url = 'https://www.google.com/recaptcha/api/siteverify?secret=6Le6CQopAAAAAM5FUeFatNKC7Rqc5ziE1FbTuJiY&response=' . $recaptcha . '&remoteip=' . $_SERVER['REMOTE_ADDR'];
            $reponse = json_decode(file_get_contents($url), true);

            if ($reponse['success'] == true && $reponse['score']>=0.5) {
                $data = new BookingFormModel;

                $code_booking = IdGenerator::generate([
                    'table' => 'tb_booking_form', 
                    'field' => 'code', 
                    'length' => 8,
                    'prefix' =>'B'.date('ym'),
                    'reset_on_prefix_change' => true 
                ]);

                $period = TourPeriodModel::where(['tour_id'=>$request->tour_id,'id'=>$request->period_id])->whereNull('deleted_at')->first();

                if($period){
                    $data->start_date = $period->start_date;
                    $data->end_date = $period->end_date;
                }
    
                $data->code = $code_booking;
                $data->tour_id = $request->tour_id;
                $data->period_id = $request->period_id;
                $data->num_twin = $request->qty1;
                $data->num_single = $request->qty2;
                $data->num_child = $request->qty3;
                $data->num_childnb = $request->qty4;
                $data->price1 = $request->price1;
                $data->sum_price1 = $request->sum_price1;
                $data->price2 = $request->price2;
                $data->sum_price2 = $request->sum_price2;
                $data->price3 = $request->price3;
                $data->sum_price3 = $request->sum_price3;
                $data->price4 = $request->price4;
                $data->sum_price4 = $request->sum_price4;
                $data->total_price = $request->net_total;
                $data->total_qty = $request->total_qty;

                $data->name = $request->name;
                $data->surname = $request->surname;
                $data->email = $request->email;
                $data->phone = $request->phone;
                $data->sale_id = $request->sale_id;
                $data->detail = strip_tags($request->detail);

                if($request->tour_id && $request->period_id){
                    if($period->count >= $request->total_qty){
                        $data->status = "Booked";
                    }else{
                        $data->status = "Waiting";
                    }
                }else{
                    $data->status = "Booked";
                }
                // $data->status = "Booked";
                
                
                $check_auth =  MemberModel::find(Auth::guard('Member')->id());
                if($check_auth){
                    $data->member_id = $check_auth->id;
                }
             
                if ($data->save()) {
                    DB::commit();

                    $tour = TourModel::find($data->tour_id);

                    Session::put('booking',$data);
                    Session::put('tour',$tour);

                    $this->sendmail_booking($data,$tour);
                    $this->sendmail_booking_admin($data,$tour);

                    return redirect(url('/booking-success'))->with(['success' => 'บันทึกข้อมูลเรียบร้อย']);
                    // return back()->with(['success' => 'บันทึกข้อมูลเรียบร้อย']);
                } else {
                    DB::rollback();
                    return back()->with(['error' => 'เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้ง!!']);
                }
    
            }else{
                return back();
            }
            

        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }

    }

    public function booking_success(){
        return view('frontend.tour_success');
    }

    public function sendmail_booking($data,$tour){
        try {
            $address = ContactModel::find(1);

            $mail = new PHPMailer(true);
            //Server settings
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Recipients
            // $mail->setFrom('noreply_nexttrip@liw.orangeworkshop.info', 'แจ้งรายละเอียดข้อมูลการสั่งจองทัวร์กับ Next trip Holiday');
            $mail->setFrom('noreply@nexttripholiday.com', 'แจ้งรายละเอียดข้อมูลการสั่งจองทัวร์กับ Next trip Holiday');
            $mail->addAddress($data->email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'แจ้งรายละเอียดข้อมูลการสั่งจองทัวร์กับ Next trip Holiday';
            $mail->Body    = '';
            $mail->Body .= $this->contact_sendmailv_html_header();
            $mail->Body .= $this->contact_sendmailv_html_center($data,$tour);
            $mail->Body .= $this->contact_sendmailv_html_footer($address);

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

    public function sendmail_booking_admin($data,$tour){
        try {
            $address = ContactModel::find(1);
            $sale = User::find($data->sale_id);
            $link = url("/webpanel/booking-form/view/$data->id");

            $mail = new PHPMailer(true);
            //Server settings
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Recipients
            // $mail->setFrom('noreply_nexttrip@liw.orangeworkshop.info', 'แจ้งรายละเอียดข้อมูลการสั่งจอง');
            $mail->setFrom('noreply@nexttripholiday.com', 'แจ้งรายละเอียดข้อมูลการสั่งจอง');
            $mail->addAddress($address->mail);
            // if($sale){
            //     $mail->addAddress($sale->email);
            // }

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'แจ้งรายละเอียดข้อมูลการสั่งจอง';
            $mail->Body    = '';
            $mail->Body .= $this->contact_sendmailv_html_header();
            $mail->Body .= $this->contact_sendmailv_html_center_admin($data,$tour,$link);
            $mail->Body .= $this->contact_sendmailv_html_footer($address);

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

    public function contact_sendmailv_html_header()
    {
        return $detail	= '
            <html>
                <table width="800" border="0" cellspacing="0" cellpadding="0" bgcolor="white" align="center">
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td	style="width:5%;background-color:orange;line-height: 2px;"">&nbsp;</td>
                        </tr>';
    }

    public function contact_sendmailv_html_center($data,$tour)
    {
        $month = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
        return $detail	= '
                        <tr>
                            <td>
                                <center>
                                    <table width="100%" cellspacing="0" cellpadding="0" style="font-family: Sarabun, sans-serif;border: 1px solid transparent;background-color:transparent; " >
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>เรียน : </b> <span style="margin-left:15px;">คุณ '.$data['name'].' '.$data['surname'].'</span></td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>ชื่อเรื่อง : </b> <span style="margin-left:15px;">แจ้งสถานะข้อมูลการจองโปรแกรมทัวร์</span></td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent; padding-top:.5rem; padding-bottom:.5rem;"><span style="margin-left:15px;">คำสั่งจองหมายเลข <span style="color:orange;">'.$data['code'].'</span> ของคุณ ได้รับการยืนยันการจองเข้ามาแล้ว และผู้ขายได้รับการแจ้งเตือนให้ตรวจสอบคำสั่งจองของคุณแล้ว</span></td>
                                        </tr>
                                        <tr style="background-color:lightgray;line-height: 0.2px; !important;">
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>รายละเอียดคำสั่งจอง </b> <span style="margin-left:15px;"></span></td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>หมายเลขคำสั่งจอง : </b> <span style="margin-left:15px; color:orange;">'.$data['code'].'</span></td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>สถานะ : </b> <span style="margin-left:15px;">'.$data['status'].'</span></td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>วันที่สั่งจอง : </b> <span style="margin-left:15px;">'. date('d',strtotime($data['created_at'])) .' '. $month[date('n',strtotime($data['created_at']))] .' '. date('y', strtotime('+543 Years', strtotime($data['created_at']))) .' '. date('H:i:s', strtotime($data['created_at'])) .'</span></td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>ชื่อ-นามสกุล : </b> <span style="margin-left:15px;">คุณ '.$data['name'].' '.$data['surname'].'</span></td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>รหัสทัวร์ : </b> <span style="margin-left:15px;">'.@$tour['code'].'</span></td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>ชื่อโปรแกรมทัวร์ : </b> <span style="margin-left:15px;">'.@$tour['name'].'</span></td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>วันที่เดินทาง : </b> <span style="margin-left:15px;">'. date('d',strtotime($data['start_date'])) .' '. $month[date('n',strtotime($data['start_date']))] .' '. date('y', strtotime('+543 Years', strtotime($data['start_date']))) .' - '. date('d',strtotime($data['end_date'])) .' '. $month[date('n',strtotime($data['end_date']))] .' '. date('y', strtotime('+543 Years', strtotime($data['end_date']))) .'</span></td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>จำนวน : </b> <span style="margin-left:15px;">'.@$data['total_qty'].' คน</span></td>
                                        </tr>
                                        <tr style="background-color:lightgray;line-height: 0.2px; !important;">
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr style="font-size:13px;">
                                            <td style="font-family: Sarabun, sans-serif;border: 1px solid transparent;padding-top:1rem; padding-bottom:.5rem;"><b>เงื่อนไขการสำรองที่นั่งกับ Next Trip Holiday </b><br><ul><li>โปรดรอเจ้าหน้าที่ติดต่อกลับเพื่อทำการ Confirm ที่นั่ง</li><li>การสำรองที่นั่งนี้จะสมบูรณ์ก็ต่อเมื่อทางบริษัทฯ ได้รับการชำระเงินเรียบร้อยแล้ว</li></ul></td>
                                        </tr>
                                    </table>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>';
    }

    public function contact_sendmailv_html_footer($data)
    {
        return $detail	= '
                        <tr style="background-color:lightgray;line-height: 1px;">
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                    <table width="100%" cellspacing="0" cellpadding="15" style="font-family: Sarabun, sans-serif;border: 1px solid transparent;background-color:transparent; " >
                                    <tr>
                                        <td style="width:50%;">
                                            <span style="font-size: 12px;color:gray; line-height:20px; ">'
                                                .$data->address.'
                                            </span>
                                        </td>
                                        <td style="width:40%;  text-align:right;"><span style="font-size: 12px;color:gray; line-height:20px;">Tel: '.$data->phone_front.'</span></td>
                                    </tr>
                                    </table>
                                </center>
                            </td>
                        </tr>
                    </table>
                </html>';
    }

}