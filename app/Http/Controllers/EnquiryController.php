<?php

namespace App\Http\Controllers;

use App\Enquiry;
use App\User;
use Illuminate\Http\Request;
use Excel;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:enquiry-list|enquiry-create|enquiry-edit|enquiry-delete', ['only' => ['index','show']]);
         $this->middleware('permission:enquiry-create', ['only' => ['create','store']]);
         $this->middleware('permission:enquiry-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:enquiry-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->roles()->first()->name == User::ADMIN_VAL){
            $enquiries = Enquiry::with('getUsers')->latest()->paginate(5);
        }
        else{
            $enquiries = Enquiry::where('user_id', auth()->user()->id)->latest()->paginate(5);
        }
        return view('enquiry.index',compact('enquiries'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::latest()->get();
        return view('enquiry.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required|max:120',
        ]);


        Enquiry::create($request->all());


        return redirect()->route('enquiries.index')
                        ->with('success','Enquiry created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function show(Enquiry $enquiry)
    {
        return view('enquiry.show',compact('enquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function edit(Enquiry $enquiry)
    {
        // $users = User::latest()->get();
        return view('enquiry.edit',compact('enquiry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enquiry $enquiry)
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required|max:120',
        ]);


        $enquiry->update($request->all());


        return redirect()->route('enquiries.index')
                        ->with('success','Enquiry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();


        return redirect()->route('enquiries.index')
                        ->with('success','Enquiry deleted successfully');
    }

    public function downloadExcel($type)
    {
        $data = Enquiry::get()->toArray();
        return Excel::create('Enquiry Data', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }
}
