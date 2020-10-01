<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class SubscriberController extends Controller
{
    public function index()
    {
      $subscribers = Subscriber::latest()->get();
      return view('admin.subscriber',compact('subscribers'));
    }

    public function destroy($subscriber)
    {
        $subscriber = Subscriber::find($subscriber);
        $subscriber->delete();
        Toastr::success('Subscriber Successfully Deleted from list','Success');
        return redirect()->back();
    }
}
