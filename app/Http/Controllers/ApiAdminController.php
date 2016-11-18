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
        if($request->pass == "@Onkoloji11@")
            return LogViewer::tree();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
