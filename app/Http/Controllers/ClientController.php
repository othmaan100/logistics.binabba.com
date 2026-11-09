<?php

namespace App\Http\Controllers;
use App\Models\client;
use App\Models\Good;
use PDF;
use Illuminate\Support\Facades\DB;
use NumberToWords\NumberToWords;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
        $clients = client::all();
       return view('admin.clients', compact('clients'));
        // return view('admin.clients', [
        //     'clients' => DB::table('tbl_clients')->simplePaginate(5)
        // ]);

    }

    public function indexpdf()
    {
        # code...
        $clients = client::all();
       // return view('admin.clients.indexpdf', compact('clients'));
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('admin.clients.indexpdf', compact('clients'));
      
        return $pdf->download('client_list.pdf');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $count=count(client::all());
        $count++;
        return view('admin.createclients')->with('count',$count);
        
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
        $request->validate([
            
            'client_name' => 'required',
            'client_phone' => 'required',
            'client_address' => 'required|string',
    
            ]);

            $client= new client;
            $client->client_name= $request->input('title') ." ". $request->input('client_name');
            $client->client_phone = $request->input('client_phone');
            $client->client_address = $request->input('client_address');
            $client->save();
            /* return redirect('/posts')->with('success', 'Post Created');

    
            clients::create($request->all()); */
    
            return redirect()->route('admin-clients.index')
    
                    ->with('success','Client Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(client $client)
    {
        //
        return view('clients.show',compact('client'));
 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    // public function edit(client $client)
    // {
    //     //
    //     //return client;
    //     //return view('admin.editclient', compact('client'));
    //     return view('admin.editclient');

    // }

    public function edit(string $id)
    {
        $client = client::find($id);

        // return View::make('admin.editclient')
        //     ->with('client', $client);
        return view('admin.editclient', compact('client'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, client $client)
    // {
    //     //
    //     $request->validate([
    //         'title' => 'string',
    //         'client_name' => 'required',
    //         'client_phone' => 'required',
    //         'client_address' => 'required|string',
    //         ]);
    
    //         $client->update($request->all());
    
    //         return redirect()->route('admin-clients.index')->with('success','client information updated successfully');
     
    // }

    public function update(Request $request, string $id)
    {
        $rules = array(
           'title' => 'string',
            'client_name' => 'required',
            'client_phone' => 'required',
            'client_address' => 'required|string',
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('admin-clients/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {
            // store
            $client = client::find($id);
            $client->client_name       = $request->get('client_name');
            $client->client_phone      = $request->get('client_phone');
            $client->client_address= $request->get('client_address');
            $client->save();

            // redirect
            return redirect()->route('admin-clients.index')->with('success','Client information updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(client $client)
    {
        //
        $client->delete();



        return redirect()->route('clients.index')

                ->with('success','client Record deleted successfully');

    }
    public function clientGood($client)
    {
        # code...
        $driverall = client::find('$client')->firstOrFail()->myGood; 
        //$driverall = Drivers::find(1)->myTruck;
    }

    public function transactions( $id)
    {
     
        //$good= Good::find($id)->myPayments;// retriving amount paid for a good 
        $client= client::find($id);
        $trans= client::find($id)->myGood;

        $payments= client::find($id)->myPayments;

        //return $payments;
        $total_cost= $trans->sum('good_cost');
        //$numberToWords = new NumberToWords();
        // build a new number transformer using the RFC 3066 language identifier
        //$numberTransformer = $numberToWords->getNumberTransformer('en');
        //$tcwords=$numberTransformer->toWords($total_cost);
        //$tcwords = SpellNumber::value($total_cost)->locale('es')->toLetters();
        
        
        //$tcwords="Cash";
        //dd($good);
       return view('admin.transaction',compact('trans','client'))->with('total_cost',$total_cost);
    }

    public function updateBulk(Request $request)
    {

        //return $request;
        $request->validate([
            'bulky_advance' => 'required',
            'client_id' => 'required',
            
            ]);

            if ($request->get('add')=='1') {
                # code...
                $client = client::find($request->get('client_id'));
                $client->bulky_advance = $client->bulky_advance + $request->get('bulky_advance');
                $client->save();
                return redirect()->route('admin-clients.index')->with('success','client Bulky-Advance updated successfully');

            }
            
    }

    public function transactionspdf($id)
    {
          //$good= Good::find(2)->myPayments;// retriving amount paid for a good
        
        $client= client::find($id);
        $trans= client::find($id)->myGood;
        $total_cost= $trans->sum('good_cost');
        $numberToWords = new NumberToWords();
        // build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        //$tcwords=$numberTransformer->toWords($total_cost);
        $tcwords="yhbvvv";

        
         //return view('clients.pdftest',compact('trans','client','tcwords','total_cost'));

        
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        //$pdf = PDF::loadView('clients.pdftest',compact('trans','client','tcwords','total_cost'));
        $pdf = PDF::loadView('clients.transactionpdf',compact('trans','client','tcwords','total_cost'));
        return $pdf->download('client_transactions.pdf');

       
    }
}
