<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Referral;
use App\User;

class HomeController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

         if ($request->user()) {
           $user = $request->user();
         }

         if($user->hasRole('admin')){

           return redirect()->route('admin.index');

         }

        $referrals = Referral::where('user_id', '=', $user->id)->get();

        $referrers = User::where('wholesaler_id', '=', $user->id)->get();

        return view('home',['user' => $user, 'referrals' => $referrals, 'referrers' =>  $referrers]);
    }

    public function getUserUpdate($user_id){

      $accessingUser = Auth::User();

      $user = User::where('id', '=', $user_id)->first();

      if($accessingUser->id === $user->id){

        return view('auth.user_update', ['user' => $user]);

      }

      //$successMsg = "Your User Information has been updated.";

      return redirect()->route('home')->with(['error' => "You are unauthorized to edit this user" ]);
    }

    public function postUserUpdateSave(Request $request){

      $this->validate($request, [

        'id' => 'required|integer',
        'username' => 'required',
        'useremail' => 'required|email'

      ]);

      $user = User::where('id', '=', $request['id'])->first();

      $accessingUser = Auth::User();

      if($accessingUser->id === $user->id){

        $user->name = $request['username'];
        $user->email = $request['useremail'];
        $user->update();

        $successMsg = "Your User Information has been updated.";

        return redirect()->route('home')->with(['success' => $successMsg ]);

      }

      return redirect()->route('home')->with(['error' => "You are unauthorized to edit this user" ]);

    }


    public function getReferrerView($user_id){

      $accessingUser = Auth::User();

      $user = User::where('id', '=', $user_id)->first();

      if($accessingUser->id != $user->wholesaler_id){

        return redirect()->route('home')->with(['fail' => 'You are not authorized to view this content']);

      }


      $referrals = Referral::where('user_id', '=', $user->id)->get();

      return view('wholesaler_referrer', ['user' => $user, 'referrals' => $referrals]);
    }


    public function getCommissionEdit($user_id){

      $user = User::where('id', '=', $user_id)->first();
      return view('commission_edit',['user' => $user]);
    }

    public function postCommissionSave(Request $request){

      $this->validate($request, [

        'id' => 'required|integer',
        'commission' => 'required|integer'

      ]);

      $user = User::where('id', '=', $request['id'])->first();
      $user->percentage = $request['commission'];
      $user->update();

      $successMsg = "Commission Successfully updated for {$user->name} ({$user->email})";

      return redirect()->route('home')->with(['success' => $successMsg ]);

    }

    public function getReferralCSV($user_id){

      $accessingUser = Auth::User();

      //dd($accessingUser->id == $user_id);

      if($accessingUser->id != $user_id){

        return redirect()->route('home')->with(['fail' => 'You are not authorized to view this content']);

      }

      $user = User::where('id', '=', $user_id)->first();
      $referrals = Referral::where('user_id', '=', $user->id)->get();
      $table = Referral::where('user_id', '=', $user->id)->get();
      $filename = "referrals-".$user->email.".csv";
      $handle = fopen($filename, 'w+');
      fputcsv($handle, array('Referral Email','Amount', 'Created At'));//, 'User', 'name', 'created at'));

      foreach($table as $row) {
          fputcsv($handle, array($row['referral_email'],$row['referral_amount'],$row['created_at']));//, $row['screen_name'], $row['name'], $row['created_at']));
      }

      fclose($handle);

      $headers = array(
          'Content-Type' => 'text/csv',
      );
      //return view('home',['user' => $user, 'referrals' => $referrals, 'accesser' => $accessingUser]);
      return Response::download($filename, $filename, $headers);

    }
}
