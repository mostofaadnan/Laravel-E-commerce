<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timezone;
use App\Models\Language;
class TimeZoneLocalController extends Controller
{
  public function index(){
    $time_zones=Timezone::all();
    $Languages=Language::all();
      return view('setup.timezone',compact('time_zones','Languages'));
  }
}
