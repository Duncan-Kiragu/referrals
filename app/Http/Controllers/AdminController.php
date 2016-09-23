<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Referral;
use App\User;
use App\Role;
class AdminController extends Controller{


  public function getIndex()
  {
    //$posts = Post::orderBy('created_at', 'desc')->take(3)->get();

    $referrals = Referral::orderBy('created_at', 'desc')->take(15)->get();

    return view('admin.index', ['referrals' => $referrals]);
  }

  public function getReferrers()
  {
    $referrers = User::whereHas('roles', function($q){$q->whereIn('name', ['referrer']);})->get();
    return view('admin.referrers', ['referrers' => $referrers]);//, ['posts' => $posts]);
  }

  public function getWholesalers()
  {
    $wholesalers = User::whereHas('roles', function($q){$q->whereIn('name', ['wholesaler']);})->get();
    return view('admin.wholesalers', ['wholesalers' => $wholesalers]);//, ['posts' => $posts]);
  }

  public function getSingleReferrer($user_id)
  {
    //$user_id = $request['user_id'];

    $user = User::where('id', '=', $user_id)->first();

    $referrals = Referral::where('user_id', '=', $user->id)->get();

    return view('admin.referrers_single', ['user' => $user, 'referrals' => $referrals]);//, ['posts' => $posts]);
  }

  public function getSingleWholesaler($user_id)
  {
    //$user_id = $request['user_id'];

    $user = User::where('id', '=', $user_id)->first();

    $referrals = Referral::where('user_id', '=', $user->id)->get();

    $referrers = User::where('wholesaler_id', '=', $user->id)->get();

    return view('admin.wholesalers_single', ['user' => $user, 'referrals' => $referrals, 'referrers' => $referrers ]);//, ['posts' => $posts]);
  }


  public function getWholesalerRemove($user_id){

    $user = User::where('id', '=', $user_id)->first();
    if(!$user){

      return redirect()->back()->with(['fail' => 'Could not find User']);

    }

    $referrerRole = Role::where('name', '=', 'referrer')->first();
    $user->roles()->detach();
    $user->roles()->attach($referrerRole->id);


    return redirect()->back()->with(['success' => 'Wholesaler Role Successfully Removed from User']);
  }



  public function getDeleteReferral($referral_id){

    $referral = Referral::find($referral_id);
    if(!$referral){

      return redirect()->back()->with(['fail' => 'Referral could not be deleted']);

    }

    $referral->delete();

    return redirect()->back()->with(['success' => 'Referral Successfully Deleted']);
  }

  public function getAddReferral()
  {
    $referrers = User::whereHas('roles', function($q){$q->whereIn('name', ['referrer']);})->get();
    return view('admin.add_referral', ['referrers' => $referrers]);//, ['posts' => $posts]);
  }

  public function getAddWholesaler()
  {
    $wholesalers = User::whereHas('roles', function($q){$q->whereIn('name', ['wholesaler']);})->get();
    return view('admin.add_wholesaler', ['wholesalers' => $wholesalers]);//, ['posts' => $posts]);
  }

  public function getLinkReferrerWholesaler()
  {
    $referrers = User::where('wholesaler_id','=', null)->whereHas('roles', function($q){$q->whereIn('name', ['referrer']);})->get();
    $wholesalers = User::whereHas('roles', function($q){$q->whereIn('name', ['wholesaler']);})->get();
    return view('admin.link_referrer_wholesaler', ['wholesalers' => $wholesalers, 'referrers' => $referrers]);//, ['posts' => $posts]);
  }

  public function postLinkWholesalerReferrer(Request $request){

    $this->validate($request, [

      'referrer' => 'required',
      'wholesaler' => 'required'

    ]);


    $referrer = User::where('id', '=', $request['referrer'])->first();

    if($referrer->wholesaler_id != null){

      return redirect()->route('admin.index')->with(['fail' => 'That Referrer ('.$referrer->name.' - '.$referrer->email.') is already associated with a wholesaler.']);

    }

    $referrer->wholesaler_id = $request['wholesaler'];
    $referrer->update();

    $wholesaler = User::where('id', '=', $request['wholesaler'])->first();

    $referrals = Referral::where('user_id', '=', $request['wholesaler'])->get();

    return redirect()->route('admin.wholesalers_single', ['user' => $wholesaler, 'referrals' => $referrals])->with(['success' => 'Referrer ('.$referrer->name.' - '.$referrer->email.') Successfully added to Wholesaler ('.$wholesaler->name.' - '.$wholesaler->email.')']);


  }

  public function postCreateReferral(Request $request){

    $this->validate($request, [

      'referrer' => 'required',
      'referral_email' => 'required|email',
      'amount' => 'required'

    ]);


    $referral = new Referral();
    $referral->user_id = $request['referrer'];
    $referral->referral_email = $request['referral_email'];
    $referral->referral_amount = $request['amount'];
    $referral->save();

    //attach categories

    return redirect()->route('admin.referrers_single', ['user_id' => $referral->user_id])->with(['success' => 'Referral Successfuly Created']);

  }

  public function postCreateWholesaler(Request $request){

    $this->validate($request, [

      'referrer' => 'required'

    ]);


    $user = User::where('id', '=', $request['referrer'])->first();

    $wholesaleRole = Role::where('name', '=', 'wholesaler')->first();

    $user->roles()->attach($wholesaleRole->id);


    return redirect()->route('admin.wholesalers')->with(['success' => 'Wholesaler Successfuly Created']);

  }


  public function getReferrerCSV($user_id){

    $user = User::where('id', '=', $user_id)->first();

    $table = Referral::where('user_id', '=', $user->id)->get();
    $filename = "referrals-".$user->email.".csv";
    $handle = fopen($filename, 'w+');


    fputcsv($handle, array('Referral Email','Amount', 'Commission', 'Created At'));//, 'User', 'name', 'created at'));

    foreach($table as $row) {
        if($user->wholesaler_id != NULL){

          $commission = $row['referral_amount'] * ($user->percentage/100);

        }else{$commission = "N/A";}




        fputcsv($handle, array($row['referral_email'],$row['referral_amount'],$commission,$row['created_at']));//, $row['screen_name'], $row['name'], $row['created_at']));
    }

    fclose($handle);

    $headers = array(
        'Content-Type' => 'text/csv',
    );

    return Response::download($filename, $filename, $headers);

  }

}
