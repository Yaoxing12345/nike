<?php

namespace App\Http\Controllers;

use App\Currency;
use Validator;
use Config;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */

    public function __construct(){
        $this->middleware('auth', ['except' => 'logout']);
    }

    
    public function getCurrencyList(Currency $currency){   
        $currencyData = Currency::all();
        $returnArr = array();            
        foreach ($currencyData as $currency) {
           $returnArr[$currency['code']] = $currency['name'].'('.$currency['symbol'].')';  
        }
        return view('currency.converter',array('cd_data'=>$returnArr));
    }

    public function convertCurrency(Request $request){
        $fromCountry = $request->input('c_from');
        $toCountry = $request->input('to_country');
        $res = $this->_fetchConversionRate($toCountry);
        print_r($res);
    }


    private function _fetchConversionRate($toCountry,$fromCountry){
        $url = config('const.CURRENCY_API_URL');
        $ch = curl_init($url.$toCountry);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $conversionResult = json_decode($json, true);
        return $conversionResult;
    }

    public function getConversionFactor(Request $request){
        $fromCountry = $request->input('from_country');
        $toCountry = $request->input('to_country');
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
        return response()->json(['status' => 200,'cf' => $cf]);
    }
}

?>