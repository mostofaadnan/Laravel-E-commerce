<?php

namespace App\Http\Controllers;
use Artisan;
use Illuminate\Http\Request;

class RunMigrateController extends Controller
{
    public function RunMigrate(){
       $migrate= Artisan::call('migrate');
         dd($migrate);
    }
}
