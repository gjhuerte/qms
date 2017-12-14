<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LRedis;
use Validator;
use Carbon;
use App;
use Auth;
use Event;

class QueuesController extends Controller
{
    public function index()
    {
    	return view('queue.index');
    }

    public function showGenerateForm()
    {
    	return view('queue.generate');
    }

    public function generate(Request $request)
    {

    	$name = $request->get('name');
    	$category = $request->get('category');
    	$purpose = $request->get('purpose');

    	$validator = Validator::make([
    		'category' => $category,
    		'name' => $name,
    		'purpose' => $purpose
		],App\Voucher::rules());

		if($validator->fails())
		{
			\Alert::error('Problem encountered while creating a queue')->flash();
			return back()
					->withInput()
					->withErrors($validator);
		}

    	$voucher = new App\Voucher;
    	$voucher->customer_name = $name;
    	$voucher->category = $category;
    	$voucher->purpose = $purpose;
        $voucher->attended_by = null;
    	$voucher->validity = Carbon\Carbon::now()->endOfDay();
    	$voucher->status = 'on queue';
    	$voucher->save();

        event(new App\Events\CreateQueue($voucher));

    	\Alert::success('Queue Generated')->flash();

        $data = [
        'voucher' => $voucher
        ];

        $filename = "Queue-".$voucher->id.".pdf";
        $view = "queue.print";

        return $this->printPreview($view,$data,$filename);

    	return back();
    }

    public function showAttendForm(Request $request)
    {
        $id = $request->get('id');
        $status = 'currently attended';

        $this->data['voucher'] = App\Voucher::find($id);
        $this->data['voucher']->status = $status;
        $this->data['voucher']->attended_by = Auth::user()->id;
        $this->data['voucher']->save();

        event(new App\Events\AttendedQueue($this->data['voucher']));

        return view('queue.attend',$this->data);
    }

    public function attend(Request $request)
    {
        $id = $request->get('id');

        $voucher = App\Voucher::find($id);
        $voucher->status = 'attended';
        $voucher->save();

        event(new App\Events\AttendedQueue($voucher));

        \Alert::success('Request Attended')->flash();

        return redirect(config('backpack.base.route_prefix').'/dashboard');
    }

    public function cancel(Request $request)
    {
        $id = $request->get('id');

        $voucher = App\Voucher::find($id);
        $voucher->status = 'on queue';
        $voucher->save();

        event(new App\Events\AttendedQueue($voucher));

        \Alert::success('Request Cancelled')->flash();

        return redirect(config('backpack.base.route_prefix').'/dashboard');
    }

    public function printVoucher(Request $request, $id)
    {
        $voucher = App\Voucher::find($id);

        $data = [
            'voucher' => $voucher
        ];

        $filename = "Queue-".$voucher->id.".pdf";
        $view = "queue.print";

        return $this->printPreview($view,$data,$filename);

    }

    public function showCounter(Request $request)
    {
        if($request->ajax())
        {
            $vouchers = App\User::with([ 'vouchers'  => function($query){
                $query->status('currently attended');
            }])->get();
            
            return json_encode([
                'data' => $vouchers
            ]);
        }

        return view('queue.counter');
    }

    public function showList(Request $request)
    {

        $this->data['vouchers'] = App\Voucher::where('validity', '>', Carbon\Carbon::now()->startOfDay())->get();

        if($request->ajax())
        {
            return json_encode([
                'data' => $this->data['vouchers']
            ]);
        }

        return view('queue.list');
    }

    public function call(Request $request)
    {
        // $redis = LRedis::connection();
        // $data = [ 'id' => $request->get('id') ];
        // $redis->publish('call', json_encode($data));

        event(new App\Events\CallQueue($request));
        return response()->json([]);
    }
}
