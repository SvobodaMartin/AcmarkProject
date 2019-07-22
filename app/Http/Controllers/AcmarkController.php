<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Acmark;
use Illuminate\Support\Facades\DB;
use DateTime;


class AcmarkController extends Controller
{


    function show(Acmark $acmark){

        $requestedIco = request('ico');



        $title = 'Acmark';
        $company = null;

        if ($requestedIco != null)
        $company = Acmark::where('ico', $requestedIco)->first();


        if ($company != null ){

            $datetime1 = new DateTime($company->updated_at);
            $datetime2 = new DateTime(now());
            $interval = $datetime1->diff($datetime2);

            if ($interval->m == 0){
                $srcIco = $company->ico;
                $activityDsc = $this->explodeStringToAssocArray($company->activityDsc);
                $activityCode = $this->explodeStringToAssocArray($company->activityCode);
                $srcName = $company->name;
            }
            else{
                $this->getFromAres();

                $srcIco = $this->srcIco;
                $activityDsc = $this->activityDsc;
                $activityCode = $this->activityCode;
                $srcName = $this->srcName;

                $this->update($srcIco, $activityDsc, $activityCode, $srcName);

            }
        }
        elseif ($requestedIco == null){
            $srcIco = null;
            $activityDsc = null;
            $activityCode = null;
            $srcName = null;
        }
        else{
            $this->getFromAres();
            $srcIco = $this->srcIco;
            $activityDsc = $this->activityDsc;
            $activityCode = $this->activityCode;
            $srcName = $this->srcName;

            $this->store($srcIco, $activityDsc, $activityCode, $srcName);
        }

        return view('acmark', compact('title', 'srcIco', 'activityDsc', 'activityCode', 'srcName'));
    }

    public function store($srcIco, $activityDsc, $activityCode, $srcName){

        $acmark = new Acmark;
        $srcIco = (array)$srcIco;

        $acmark->ico = $srcIco[0];

        $acmark->activityDsc = $this->implodeAssocArrayToString($activityDsc);
        $acmark->activityCode = $this->implodeAssocArrayToString($activityCode);
        $acmark->name = $srcName;

        $acmark->save();

    }

    public function update($srcIco, $activityDsc, $activityCode, $srcName){


        $acmark = Acmark::where('ico', $srcIco)->first();

        $srcIco = (array)$srcIco;
        $acmark->ico = $srcIco[0];
        $acmark->activityDsc = $this->implodeAssocArrayToString($activityDsc);
        $acmark->activityCode = $this->implodeAssocArrayToString($activityCode);
        $acmark->name = $srcName;
        $acmark->updated_at = now();

        $acmark->update();

    }
    public function getFromAres(){

        $ico = null;
        if (isset($_GET['ico'])){
            $ico = $_GET['ico'];
        }
        if ($ico != null){


            $url = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=' . $ico;
            $htm = file_get_contents($url);

            $string = $htm;

            $xml=simplexml_load_string($string) or die("Error: Cannot create object");


            /* Search for ICO */
//            dd($xml->xpath('are:Odpoved/D:VBAS/D:ICO'));
            if ($xml->xpath('are:Odpoved/D:VBAS/D:ICO') == [])
                $srcIco = request('ico');
            else
            list($srcIco) = $xml->xpath('are:Odpoved/D:VBAS/D:ICO') ;

            /* Search for name */
            if ($xml->xpath('are:Odpoved/D:VBAS/D:OF') == [])
                $srcName = null;

            else
            list($srcName) = $xml->xpath('are:Odpoved/D:VBAS/D:OF');

            $activityDsc = [];
            $activityCode = [];

            /* Search for busyness activities */
            /* activity code */
            $activityLocation = "are:Odpoved/D:VBAS/D:Obory_cinnosti/D:Obor_cinnosti";
            $activity = $xml->xpath('are:Odpoved/D:VBAS/D:Obory_cinnosti/D:Obor_cinnosti');

            foreach($activity as $activities) {
                $activityCode = $xml->xpath($activityLocation . "/D:K");
            }

            /* activity description */
            $activityLocation = "are:Odpoved/D:VBAS/D:Obory_cinnosti/D:Obor_cinnosti";
            $activity = $xml->xpath('are:Odpoved/D:VBAS/D:Obory_cinnosti/D:Obor_cinnosti');

            foreach($activity as $activities) {
                $activityDsc = $xml->xpath($activityLocation . "/D:T");
            }

        }

        $this->srcIco = $srcIco;
        $this->activityDsc = $activityDsc;
        $this->activityCode = $activityCode;
        $this->srcName = $srcName;

        return $this;

    }
    public function implodeAssocArrayToString($array){
        $newArray = [];

        foreach ($array as $value){
            array_push($newArray, $value);

        }

        $newArray = implode("|",$newArray);


        return $newArray;

    }
    public function explodeStringToAssocArray($string){

        $newString = explode("|",$string);


        return $newString;

    }
}
