<?php

namespace App\Http\Controllers\noc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrTerminateRequest;
use App\Models\Provincial;
use App\Events\prTrRequestEvent;
use \Exception;
use Auth;
use DB;

class ProvincialRequestController extends Controller
{
    // Return the list of requests
    public function index()
    {
        $requests = PrTerminateRequest::latest('pr_requests.created_at');
        if (request('customer_id')) {
            $requests = $requests->where('customer_id', '=', request('customer_id'));
        }

        if (request('date') && !request('end')) {
            $requests = $requests->whereDate('request_date', '=', request('date'));
        }

        if (request('date') && request('end')) {
            $requests = $requests->whereDate('request_date', '>=', request('date'))
                ->whereDate('request_date', '<=', request('date'));
        }

        if (request('status')) {
            $requests = $requests->where('status', '=', request('status'));
        }

        $value = Auth::user()->role;
        $requests = $requests->with('user')->whereHas('user', function ($q) use ($value) {
            $q->where('role', $value);
        })->paginate(15);

        return view('noc.prRequests.index', compact('requests'));
    }

    // return the create requests form
    public function create()
    {
        return view('noc.prRequests.create');
    }

    // show the individual requests
    public function show($id)
    {
        $request = PrTerminateRequest::find($id);
        return view('noc.prRequests.show', compact('request'));
    }

    // edit the requests
    public function edit($id)
    {
        $request = PrTerminateRequest::find($id);
        return view('noc.prRequests.edit', compact('request'));
    }

    // store the requests into database
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

        $req = new PrTerminateRequest();
        $req->customer_id = $request->customer_id;
        $req->reason = $request->reason;
        $req->request_date = $request->request_date;
        $req->user_id = Auth::user()->id;

        try {
            DB::beginTransaction();

            $req->save();

            $customer = Provincial::find($request->customer_id);
            event(new prTrRequestEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('prRequests.index')->with('success', 'Operation Done.');
    }

    // update the requests
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

        $req = PrTerminateRequest::find($id);
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

        return redirect()->route('prRequests.index')->with('success', 'Operation Done.');
    }

    // destroy the requests
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $req = PrTerminateRequest::find($id);
            $req->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('prRequests.index')->with('success', 'Operation Done.');
    }
}
