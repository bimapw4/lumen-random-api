<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index()
    {
        $file = resource_path().'\pts 1801- 1900.xlsx';

        $pts = Excel::load($file, function($reader) {
            $reader->skipRows(1)->takeColumns(2);
        })->get();

        $email = Excel::load($file, function($reader) {
            $reader->skipRows(1)->takeColumns(4);
        })->get();

        $i = 0;
        foreach ($email as $value) {
            $results[] = [
                "pts" => $pts[$i][0],
                "email" => $value[0],
            ];
        $i++;
        }


        return $results;
    }
}
