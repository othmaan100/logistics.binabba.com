<div class="table-responsive">
     <table class="table table-bordered " >
    <thead>
      @csrf
    
     
        <tr>
          <th>SN</th>
          <th>Client Name</th>
          <th>  Phone Number</th>
          <th>  Address </th>
          <th>Date Registered</th>
          <th colspan="4" class="text-center">Action </th>
        </tr>
      
    </thead>
    <tbody>
        @foreach($contracts as $contract)
        <tr>
            <td></td>
            <td>{{$contract->client}}</td>
            <td>{{$contract->vendor}}</td>
            <td>{{$contract->event}}</td>
            <td>{{$contract->start_date}}</td>
            <td>{{$contract->end_date}}</td>
            <td>{{$contract->payment_amount}}</td>
           
           <td>
             <button class="btn btn-success" d="{{$contract->id}}" > Click to generate contract</button>
            </td>
       
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
  </div>
  <script>
    $(document).ready(function(){
    
    // haddling the post for generating pdf record
    $('.btn').click(function(){
    
        var contract_id = $('.btn').attr('d');
        var _token= $('input[name="_token"]').val();
    
         
       var datas="&contract_id="+contract_id+"&_token="+_token;
        console.log(datas);
        $.ajax({
        type: "POST",
        url: "{{ route('contracts.generate') }}",
        data: datas,
        success:function(data){
    
    
  /*  
    var documents = JSON.parse(editorResponse.getValue());
    download("results.pdf", documents[0]);
*/
    
    
        console.log(data);
        },
        error: function(xhr,status,error){
           var errrmsg=xhr.status+ ': '+xhr.statusText;
            alert('Eror-'+ errrmsg);
  }
        }); 
    
    });

    
    });
    
  
  
    
  </script>




//the funtion to generate pdf
     public function generate(Request $request)
    {
       
        $id=  $request->contract_id;
         $mergeD=Contract::where('id',$id)->get();
  
        $mergeData=[$mergeD];
        
         $reportingCloud = new ReportingCloud([
            'api_key'=> 'eUUz83YmB5lHubnGHJHNpZ3nffwHdV5ikpNKGGGm0',
        ]);
        
        // a template on my portal dashnord
        $templateName = 'vendor_contract.tx';

        $mergeSettings=null;
        
        $arrayOfBinaryData = $reportingCloud->mergeDocument($mergeData, 'PDF', $templateName, null, false, $mergeSettings);
     
            $destinationFile     = sprintf('test_document.pdf');
            $destinationFilename = sys_get_temp_dir() . DIRECTORY_SEPARATOR .$destinationFile;
          //var_dump("Merged {$templateName} was written to {$destinationFilename}");

        return $arrayOfBinaryData;      
        
    }
}