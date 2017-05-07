<?php

namespace App\Http\Controllers;

use App\Currency;
use Validator;
use Config;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
Use Input;
use Session;
use Log;

class CurrencyController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */

    protected $logFormat = 'className -->'.__CLASS__ .' Line No '.__LINE__;

    public function __construct(){
        $this->middleware('auth', ['except' => 'logout']);
        $user = Auth::user();
        $userId =  $user->id;
        $this->logFormat .= ' for user Id '.$userId;
    }

    
    public function getCurrencyConverterList(Currency $currency){
        $currencyData = Currency::all();
        Log::info($this->logFormat.' accessed currency conversion page');
        $returnArr = array();            
        foreach ($currencyData as $currency) {
           $returnArr[$currency['code']] = $currency['name'].'('.$currency['symbol'].')';  
        }
        return view('currency.converter',array('cd_data'=>$returnArr));
    }


    public function getCurrencyListView(){
        Log::info($this->logFormat.' accessed adding currency page');
        return view('currency.add');
    }

    public function addCurrency(Request $request){
        $input = $request->all();
        Log::info($this->logFormat.' trying to add a new currency record with request params '.json_encode($input));
        $valid = Validator::make($input, [
            'name' => 'required',
            'code'  => 'required|unique:currency',
            'symbol' => 'required',
            'base_usd_amount'=> 'required'
        ]);

        if($valid->fails()){
            Log::info($this->logFormat.' Validation got failed reason'.json_encode($valid->errors()));
            return view('currency.add')->withErrors($valid)->withInput(Input::except('password'));
        }
        
        try{
            $res = Currency::create([
                'name'=>$input['name'],
                'code' => $input['code'],
                'symbol'=> $input['symbol'],
                'base_usd_amount' => $input['base_usd_amount'],
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
            Log::info($this->logFormat.' New Currency got succelly created');
            return Redirect::to('currency-list');
        }catch(\Exception $e){
            Log::info($this->logFormat.' Exception ocuured while creating currency record reason'.print_r($e->getMessage(),true));
            return view('currency.add')->withErrors('Oops Something went wrong');
        }
    }

    public function getConversionFactor(Request $request){
        $fromCountry = $request->input('from_country');
        $toCountry = $request->input('to_country');

        Log::info($this->logFormat.' User fetching conversation rate from Country '.$fromCountry.' And to Country '.$toCountry);
        $currency = DB::table('currency')
                ->select('code', 'base_usd_amount')
                ->whereIn('code', [$fromCountry, $toCountry])
                ->get();

        $resultArray = json_decode(json_encode($currency),true);

        $baseAmountFromCountry = 0;
        $baseAmountToCountry = 0;
        foreach ($resultArray as $key => $value) {
            if($value['code'] ==  $fromCountry)
                $baseAmountFromCountry = $value['base_usd_amount'];
            else if($value['code'] ==  $toCountry)
                $baseAmountToCountry = $value['base_usd_amount'];
        }

        $cf = $baseAmountFromCountry / $baseAmountToCountry;
        Log::info($this->logFormat.' returning '.$cf.' as conversation rate from Country '.$fromCountry.' And to Country '.$toCountry);
        return response()->json(['status' => 200,'cf' => $cf]);
    }

    public function getCurrencyList(){
        Log::info($this->logFormat.' accessed adding currency page');
        $currency = DB::table('currency')
                    ->select('id as ID','name as Name','code as Code','symbol as Symbol','base_usd_amount as Base Converstion','created_at as Created-On','updated_at as Updated-On','status')
                    ->orderBy('id', 'desc')
                    ->get();
        $returnArr = json_decode(json_encode($currency),true);
        return view('currency.list',array('cd_data'=>$returnArr));
    }

    public function getCurrencyDetailsById($id){
        Log::info($this->logFormat.' accessed edit currency page for currency id '.$id);
        $res = Currency::find($id);
        $returnArr = json_decode(json_encode($res),true);
        return view('currency.edit',array('details'=>$returnArr));
    }

    public function updateCurrencyConversionById(Request $request){
        $currencyId = $request->input('id');
        $conversionAmount = $request->input('base_usd_amount');
        Log::info($this->logFormat.' user editing for currency Id '.$currencyId.' with conversion Amount '.$conversionAmount);
        try{
            Currency::where('id', $currencyId)
                     ->update(['base_usd_amount' => $conversionAmount,'updated_at'=>date('Y-m-d h:i:s')]); 
            Log::info($this->logFormat.' user successfully edited for currency Id '.$currencyId.' with conversion Amount '.$conversionAmount);   
            return Redirect::to('currency-list');
        }catch(\Exception $e){
            Log::info($this->logFormat.' Exception ocuured while creating currency record reason'.print_r($e->getMessage(),true));
            return view('currency.edit');
        }
    }

    public function toggleCurrencyConversionById($id,$status){
        Log::info($this->logFormat.' user going to set '.$status.' for currency Id '.$id);
        try{
            Currency::where('id', $id)
                     ->update(['status' => $status,'updated_at'=>date('Y-m-d h:i:s')]); 
            Log::info($this->logFormat.' user successfully set '. $status.'for currency Id '.$id);
            return Redirect::to('currency-list');
        }catch(\Exception $e){
            Log::info($this->logFormat.' Exception ocuured while creating currency record reason'.print_r($e->getMessage(),true));
            return view('currency.edit');
        }
    }
    
}

?>