<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestTerminate;
use App\Models\Customer;
use App\Events\requestEvent;
use \Exception;
use DB;
use Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $requests = RequestTerminate::latest('requests.created_at');
        if (request('customer_id')) {
            $requests = $requests->where('customer_id', '=', request('customer_id'));
        }

        if (request('date')) {
            $requests = $requests->whereDate('request_date', '=', request('date'));
        }

        if (request('sender')) {
            $requests = $requests->join('users', 'requests.user_id', '=', 'users.id')
                ->where('users.name', 'like', '%' . request('sender') . '%');
        }

        if (request('status')) {
            $requests = $requests->where('status', '=', request('status'));
        }

        $requests = $requests->where('user_id', Auth::user()->id)
            ->paginate(15);
        return view('finance.requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('finance.requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'request_date' => 'required',
            'reason' => 'required',
        ], [
            'customer_id.required' => 'Customer is required',
            'request_date.required' => 'Request date is required',
            'reason.required' => 'Request reason is required',
        ]);

        $req = new RequestTerminate();
        $req->customer_id = $request->customer_id;
        $req->reason = $request->reason;
        $req->request_date = $request->request_date;
        $req->user_id = Auth::user()->id;

        try {
            DB::beginTransaction();

            $req->save();

            $customer = Customer::find($request->customer_id);
            event(new requestEvent($customer));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('requests.index')->with('success', 'Operation Done.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = RequestTerminate::find($id);
        return view('finance.requests.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $request = RequestTerminate::find($id);
        return view('finance.requests.edit', compact('request'));
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
        $request->validate([
            'customer_id' => 'required',
            'request_date' => 'required',
            'reason' => 'required',
        ], [
            'customer_id.required' => 'Customer is required',
            'request_date.required' => 'Request date is required',
            'reason.required' => 'Request reason is required',
        ]);

        $req = RequestTerminate::find($id);
        $req->customer_id = $request->customer_id;
        $req->reason = $request->reason;
        $req->request_date = $request->request_date;
        $req->user_id = Auth::user()->id;

        try {
            DB::beginTransaction();
            $req->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('requests.index')->with('success', 'Operation Done.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $req = RequestTerminate::find($id);
            $req->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('requests.index')->with('success', 'Operation Done.');
    }
}
