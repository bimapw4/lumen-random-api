<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class AlgoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function paspor(Request $request)
    {
        $day = $request->input("day");
        $date = $request->input("date");
        $month = $request->input("month");

        if ($day == "senin") {
            $hari = "rabu";
        } else if ($day == "selasa"){
            $hari = "kamis";
        } else if ($day == "rabu"){
            $hari = "jumat";
        }else if ($day == "kamis"){
            $hari = "senin";
        }else if ($day == "jumat"){
            $hari = "selasa";
        } else {
            $hari = "hari libur gan";
        }

        if ($day == "senin" || $day == "selasa" || $day == "rabu") {
            $tanggal = $date + 2;
        } else if($day == "kamis" || $day == "jumat"){
            $tanggal = $date + 4;
        } else {
            $tanggal = "tanggal libur BNGSAT";
        }

        if ($month <= 12) {
            if ($tanggal > 30) {
                $tanggal = $tanggal - 30;
                $bulan = $month + 1;

                    if ($bulan > 12) {
                        $bulan = $bulan - 12;
                    }
            }else {
                $bulan = $month;    
            }
        } else {
            $bulan = "bulan sampe 12 bodoh";
        }
        

        return response()->json([
            "hari" => $hari,
            "tanggal" => $tanggal,
            "bulan" => $bulan 
        ]);
    }

    public function KasirSwalayan(Request $request)
    {
        $total = $request->input("total");

        if ($total > 100000 && $total <= 30000) {
            $diskon = "5%";
            $bayar  = 5 / 100 * $total;
        } else if ($total > 300000 && $total <= 500000){
            $diskon = "10%";
            $bayar  = 10 / 100 * $total;
        } elseif ($total > 500000) {
            $diskon = "15%";
            $bayar  = 15 / 100 * $total;
        } else {
            $diskon = "0%";
            $bayar = $total;
        }
        
        if ($bayar >= 50000) {
            $voucher = $bayar /50000;
        } else {
            $voucher = 0; 
        }

        return Response()->json([
            "Diskon Harga" => $diskon,
            "Harga Bayar" => $bayar,
            "voucher" =>(int)$voucher
        ]);
    }
    
    public function ocr(Request $request)
    {
        // $image = $request->file('image');
        // $name = time().'.'.$image->getClientOriginalExtension();
        // $destinationPath = storage_path('/app/images');
        // $image->move($destinationPath, $name);
       
        $imageAnnotator = new ImageAnnotatorClient();
        $fileName = $request->file("image");
        $image = file_get_contents($fileName);

        # performs label detection on the image file
        $response = $imageAnnotator->labelDetection($image);
        $labels = $response->getLabelAnnotations();

        if ($labels) {
            echo("Labels:" . PHP_EOL);
            foreach ($labels as $label) {
                echo($label->getDescription() . PHP_EOL);
            }
        } else {
            echo('No label found' . PHP_EOL);
        }
    }

    public function RajaOngkir()
    {
        for ($i=1; $i == 34; $i++) { 
            $url = "https://pro.rajaongkir.com/api/province?id="+$i;
        }
        $header = [
            "key" => "548b001ad66711758e8b24c238a7dbd2"
        ];
        return $this->GET($url,$header);
    }

    public function GET($url='', $header=array())
	{
		$ch = curl_init();
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_HTTPGET => TRUE,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HTTPHEADER => $header,
			CURLINFO_HEADER_OUT => TRUE
		);
		curl_setopt_array($ch, $options);
		$output = curl_exec($ch);
		curl_close($ch);
		$data_array = json_decode($output, TRUE);
		return $data_array;
    }
}
