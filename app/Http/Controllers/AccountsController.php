<?php

namespace App\Http\Controllers;

use App;
use DB;
use Auth;
use Hash;
use Carbon;
use Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AccountsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if($request->ajax())
		{
			return json_encode([
				'data' => App\User::all()
			]);
		}
		return view('account.index')
				->with('title','Accounts');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('account.create')
				->with('title','Accounts');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$lastname = $this->sanitizeString(Input::get('lastname'));
		$firstname = $this->sanitizeString(Input::get('firstname'));
		$middlename = $this->sanitizeString(Input::get('middlename'));
		$username = $this->sanitizeString(Input::get('username'));
		$contactnumber = $this->sanitizeString(Input::get('contactnumber'));
		$email = $this->sanitizeString(Input::get('email'));
		$password = $this->sanitizeString(Input::get('password'));
		$access = $this->sanitizeString(Input::get('access'));
		$office = $this->sanitizeString(Input::get('office'));
		$position = $this->sanitizeString(Input::get('position'));

		$validator = Validator::make([
			'Lastname' => $lastname,
			'Firstname' => $firstname,
			'Middlename' => $middlename,
			'Username' => $username,
			'Email' => $email,
			'Password' => $password,
			'Office' => $office
		],App\User::$rules);

		if($validator->fails())
		{
			return redirect('account/create')
				->withErrors($validator)
				->withInput();
		}

		DB::beginTransaction();

		$user = new App\User;
		$user->fullname = $fullname;
		$user->email = $email;
		$user->password = Hash::make($password);
		$user->save();

		DB::commit();

		\Alert::success("Account created!")->flash();
		return redirect('account');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = App\User::find($id);
		return view('account.show')
			->with('person',$user)
			->with('title','Accounts');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if(isset($id)){
			$user = App\User::find($id);
			return view('account.update')
				->with('user',$user)
				->with('title','Accounts');
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$name = $this->sanitizeString(Input::get('name'));
		$email = $this->sanitizeString(Input::get('email'));

		$user = App\User::find($id);

		$validator = Validator::make([
			'Lastname' => $lastname,
			'Firstname' => $firstname,
			'Middlename' => $middlename,
			'Email' => $email,
			'Office' => $office,
			'Username' => $username,
		],$user->updateRules());

		if($validator->fails())
		{
			return redirect("account/$id/edit")
				->withInput()
				->withErrors($validator);
		}
		
		$user->username = $name;
		$user->email = $email;
		$user->save();

		\Alert::success('Account information updated')->flash();
		return redirect('account');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request,$id)
	{
		if($request->ajax())
		{
			if($id == Auth::user()->id)
			{
				return json_encode('self');
			}
			else if(App\User::count() <= 1)
			{
				return json_encode('invalid');
			}
			else
			{
				$user = App\User::find($id);
				$user->delete();

				return json_encode('success');
			}
		}

		$user = App\User::find($id);

		if( count($user) <= 0 )
		{
			\Alert::error('Error Ocurred while processing your data')->flash();
			return Redirect::back();
		}

		$user->delete();

		\Alert::success('Account removed!')->flash();
		return redirect('account/view/delete');
	}

	/**
	 * Change User Password to Default '12345678'
	 *
	 * user id
	 *@param  int  $id
	 */
	public function resetPassword(Request $request)
	{
		if($request->ajax())
		{
			$id = $this->sanitizeString(Input::get('id'));
		 	$user = App\User::find($id);
		 	$user->password = Hash::make('12345678');
		 	$user->save();

		 	return json_encode('success');
		}
	}
}
