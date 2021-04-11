<?php

namespace App\Http\Controllers;

use App\Chatbots;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{

    public function main()
    {
        $Chatbots = Chatbots::all();
        return view('main', compact('Chatbots'), ['Chatbots' => $Chatbots]);
    }


    public function messagebot(Request $request)
    {
        $getMesg = $request->input('text');
        //checking user query to database query
        $check_data = Chatbots::where('queries','LIKE','%'.$getMesg.'%')->first();
        //$check_data = Chatbots::query()->where('name', 'LIKE', "%{getMesg}%");

// if user query matched to database query we'll show the reply otherwise it go to else statement
        if($check_data->count() > 0){
            //storing replay to a varaible which we'll send to ajax
            $replay = $check_data->replies;
            echo $replay;
        }

        if($check_data->count() <= 0){
            echo "Sorry, I dont understand you";
        }
    }
}
