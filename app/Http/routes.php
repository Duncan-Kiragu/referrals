<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', [

    'uses' => 'HomeController@index',
    'as' => 'home'

]);

Route::get('/commission/{user_id}/edit', [

    'uses' => 'HomeController@getCommissionEdit',
    'as' => 'commission.edit'

]);

Route::post('/commission/save', [

    'uses' => 'HomeController@postCommissionSave',
    'as' => 'commission.save'

]);

Route::get('/referrer/{user_id}/view', [

    'uses' => 'HomeController@getReferrerView',
    'as' => 'wholesaler.referrers_single'

]);


Route::get('/{user_id}/download', [

    'uses' => 'HomeController@getReferralCSV',
    'as' => 'referrals.download'

]);

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {

  Route::get('/', [

    'uses' => 'AdminController@getIndex',
    'as' => 'admin.index'

  ]);

  Route::get('/referrers', [

    'uses' => 'AdminController@getReferrers',
    'as' => 'admin.referrers'

  ]);

  Route::get('/wholesalers', [

    'uses' => 'AdminController@getWholesalers',
    'as' => 'admin.wholesalers'

  ]);

  Route::get('/referrers/{user_id}', [

    'uses' => 'AdminController@getSingleReferrer',
    'as' => 'admin.referrers_single'

  ]);

  Route::get('/referrers/{user_id}/delete', [

    'uses' => 'AdminController@deleteReferrer',
    'as' => 'admin.referrers_delete'

  ]);

  Route::get('/wholesalers/{user_id}', [

    'uses' => 'AdminController@getSingleWholesaler',
    'as' => 'admin.wholesalers_single'

  ]);

  Route::get('/wholesalers/{user_id}/remove', [

    'uses' => 'AdminController@getWholesalerRemove',
    'as' => 'admin.wholesaler.remove'

  ]);

  Route::get('/wholesalers/{user_id}/removeaffiliate', [

    'uses' => 'AdminController@getWholesalerRemoveAffiliate',
    'as' => 'admin.wholesaler.removeaffiliate'

  ]);




  Route::get('/referral/{referral_id}/delete', [

    'uses' => 'AdminController@getDeleteReferral',
    'as' => 'admin.referral.delete'

  ]);

  //admin.add.referral
  Route::get('/referral/add', [

    'uses' => 'AdminController@getAddReferral',
    'as' => 'admin.referral.add'

  ]);


  Route::get('/wholesaler/add', [

    'uses' => 'AdminController@getAddWholesaler',
    'as' => 'admin.wholesaler.add'

  ]);

  Route::get('/wholesaler/referrer/add', [

    'uses' => 'AdminController@getLinkReferrerWholesaler',
    'as' => 'admin.wholesaler.referrer.add'

  ]);

  Route::post('/wholesaler/referrer/link', [

      'uses' => 'AdminController@postLinkWholesalerReferrer',
      'as' => 'admin.wholesaler.referrer.link'

  ]);




  Route::post('/referral/create', [

    'uses' => 'AdminController@postCreateReferral',
    'as' => 'admin.referral.create'

  ]);

  Route::post('/wholesaler/create', [

    'uses' => 'AdminController@postCreateWholesaler',
    'as' => 'admin.wholesaler.create'

  ]);

  Route::get('/referrals/{user_id}/download', [

      'uses' => 'AdminController@getReferrerCSV',
      'as' => 'admin.referrals.download'

  ]);

    //Route::get('/', 'AdminController@getIndex');
    //Route::get('/manage', ['middleware' => ['permission:manage-admins'], 'uses' => 'AdminController@manageAdmins']);
});
