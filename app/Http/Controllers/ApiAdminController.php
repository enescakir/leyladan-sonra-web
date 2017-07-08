<?php

namespace App\Http\Controllers;

use Arcanedev\LogViewer\Facades\LogViewer;
use Illuminate\Http\Request;

use App\Http\Requests;

class ApiAdminController extends Controller
{

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function log(Request $request)
  {
    if($request->pass == "@Onkoloji11@"){
      $logs = LogViewer::tree();
      krsort($logs);
      return $logs;
    }
    return "";
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function logDaily(Request $request, $date)
  {
    if($request->pass == "@Onkoloji11@")
    return LogViewer::entries($date);
    return "";
  }
}
