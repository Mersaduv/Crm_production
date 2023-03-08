<?php

namespace App\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use App\Models\PrTerminateRequest;
use Illuminate\Http\Request;
use \Exception;
use Auth;
use DB;

class ProvincialRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = PrTerminateRequest::latest('pr_requests.created_at');
        if (request('customer_id')) {
            $requests = $requests->where('customer_id', '=', request('customer_id'));
        }

        if (request('date')) {
            $requests = $requests->whereDate('request_date', '=', request('date'));
        }

        if (request('start') && request('end')) {
            $requests = $requests->whereDate('request_date', '>=', request('start'))
                ->whereDate('request_date', '<=', request('date'));
        }

        if (request('sender')) {
            $value = request('sender');
            $requests = $requests->whereHas('user', function ($q) use ($value) {
                $q->where('role', $value);
            });
        }

        if (request('status')) {
            $requests = $requests->where('status', '=', request('status'));
        }

        $requests = $requests
            ->whereHas('customer', function ($query) {
                $query->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial', 'read'));
            })
            ->whereNull('deleted_at')->paginate(15);

        return view('sales.prRequests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = PrTerminateRequest::find($id);
        return view('sales.prRequests.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try {
            DB::beginTransaction();

            $req = PrTerminateRequest::find($id);
            $req->status = $request->status;
            $req->reject_reason = $request->reject_reason;
            $req->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->back()->with('success', 'Operation Done!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function requestEvent()
    {
        $requests = PrTerminateRequest::orderby('id', 'desc')
            ->whereNull('deleted_at')
            ->paginate('15');
        return view('sales.prRequests.portion.requests', compact('requests'));
    }
}
