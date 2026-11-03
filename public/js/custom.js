function reset() {
    requestArray = []
    stockArray=[]
    sellItemArray = []
    totalCost = 0;
    tableBody  = "";
}
function printReceipt(items,invoice,date,status,customer,chasier_name,amount_paid=null) {
    
 // console.log(customer); 
    if (!items) {
        return;
    }

   // <img src="{{ asset('log1.png') }}" alt="Description of the image">
                        
   
    var receiptContent = `<img src="public/log1.png" >
                        <link rel="shortcut icon" href="{{ asset('log1.ico') }}">
                        <div style='text-align:center;width:400px;line-hight:1'>
                        <h2 style="margin:0;padding:0;">MUHAMMAD ABDULLAHI WASE</h1>
                        <p style="margin:0;padding:0;">Address:  Nasarawa Hospital, Hospital Road GRA, Kano</p>
                        <p style='margin:0;padding:0;'>Kano State</p>
                        <h5 style='margin:0;padding:0;'>Receipt: MAWTH${invoice}</h3>
                        <p style='margin:0;padding:0;'>Date: ${date}</p>
                        <h5 style='margin:0;padding:0;'>Name: ${customer}</h4>
                        <table style="width:400px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Items</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        `;
    
    var total =0;
    var sn =0;
    var wholesale =0;
    items.forEach((item)=>{
        sn++;
        var price = item.selling_price ? item.selling_price : item.service_price;

        //console.log(price)
       
        total += item.quantity*price
        console.log(total)
        
        receiptContent += `
               
                    <tr>
                        <td align="center">${sn}</td>
                        <td align="center">${item.itemName}</td>
                        <td align="center">&#8358;${ price.toLocaleString()}</td>
                        <td align="center">${item.quantity}</td>
                        <td align="center">&#8358;${(item.quantity*price).toLocaleString()}</td>

                    </tr>
                `;
    })

   
    


        receiptContent +=`
                </tbody>
                </table>
                <h3>Total: &#8358;${total.toLocaleString()}</h3>
                <h2 style="margin:0">${status}</h2>
                <h5 style='margin:0;padding:0;'>Cashier: ${chasier_name}</h4>
                `;


    receiptContent +=`<p>Thank you for your purchase!</p></div>`
    
   
  //console.log(receiptContent);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    document.body.appendChild(iframe);
  
    var iframeDoc = iframe.contentWindow.document;
  iframeDoc.open();
  iframeDoc.write('<html><head><title>Receipt</title><style>@page { size: auto; margin: 0mm; }</style></head><body><img src="public/log1.png" >' + receiptContent + '</body></html>');
  iframeDoc.close();

  iframe.contentWindow.print();
  
    // Remove the iframe after printing
    iframe.parentNode.removeChild(iframe);
  }
  
  
  function printPReceipt(items,invoice,date,status,customer,chasier_name,amount_paid) {
    
 // console.log(customer); 
    if (!items) {
        return;
    }

   // <img src="{{ asset('log1.png') }}" alt="Description of the image">
                        
   
    var receiptContent = `<img src="{{ asset('images/log1.png') }}" alt="Logo">j
   <!-- www.mawthkano.com.ng/cashier/cashier-service/public/log1.png -->
                        <link rel="shortcut icon" href="{{ asset('log1.ico') }}">
                        <div style='text-align:center;width:400px;line-hight:1'>
                        <h2 style="margin:0;padding:0;">MUHAMMAD ABDULLAHI WASE</h1>
                        <p style="margin:0;padding:0;">Address:  Nasarawa Hospital, Hospital Road GRA, Kano</p>
                        <p style='margin:0;padding:0;'>Kano State</p>
                        <h5 style='margin:0;padding:0;'>Receipt: MAWTH${invoice}</h3>
                        <p style='margin:0;padding:0;'>Date: ${date}</p>
                        <h5 style='margin:0;padding:0;'>Name: ${customer}</h4>
                        <table style="width:400px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Items</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        `;
    
    var total =0;
    var sn =0;
    var wholesale =0;
    // items.forEach((item)=>{
    //     sn++;
    //     var price = item.selling_price ? item.selling_price : item.service_price;

    //     //console.log(price)
       
    //     total += item.quantity*price
    //     console.log(total)
        
        receiptContent += `
               
                    
                    <tr>
                        <td align="center">1</td>
                        <td align="center">${items}</td>
                        <td align="center">&#8358;${amount_paid.toLocaleString()}</td>

                    </tr>
                `;
    // })

   
    


        receiptContent +=`
                </tbody>
                </table>
                <h3>Total: &#8358;${amount_paid.toLocaleString()}</h3>
                <h2 style="margin:0">${status}</h2>
                <h5 style='margin:0;padding:0;'>Cashier: ${chasier_name}</h4>
                `;


    receiptContent +=`<p>Thank you for your purchase!</p></div>`
    
   
  //console.log(receiptContent);

    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    document.body.appendChild(iframe);
  
    var iframeDoc = iframe.contentWindow.document;
  iframeDoc.open();
  iframeDoc.write('<html><head><title>Receipt</title><style>@page { size: auto; margin: 0mm; }</style></head><body><img src="public/log1.png" >' + receiptContent + '</body></html>');
  iframeDoc.close();

  iframe.contentWindow.print();
  
    // Remove the iframe after printing
    iframe.parentNode.removeChild(iframe);
  }
  
  
var requestArray = [];
var stockArray = [];
var sellItemArray = [];
var totalCost = 0;
var tableBody = ""
$(document).ready(function (e) {

    $(document).on("click", "#addItem", function(e) {
        $('#errorTxt').text("");

        var item_id = $('#production_item_id').val();
        var itemName = $("#production_item_id").find(":selected").text();
        var quantity = $('#quantity').val();
        var measurement = $('#measurement').val();
        var unit = $("#measurement").find(":selected").text();

        var code = $('#code').val();
        var user = $('#user').val();


        var isExisting = requestArray.some(function(item) {
            return item.item_id === item_id;
        });

        if (isExisting) {
            $('#errorTxt').text("Item already exists.");
        } else if (quantity <1) {
            $('#errorTxt').text("Quantity cannot be less than 1.");

        }
        else {
            requestArray.push({ item_id: item_id, itemName, quantity: quantity, code: code,user,measurement,unit });

            tableBody = ""
            var sn = 0;
            requestArray.forEach((item) =>{
                sn++;
                tableBody +=`
                <tr>
                    <td>${sn}</td>
                    <td>${item.itemName}</td>
                    <td>${item.quantity} ${item.unit}</td>
                    <td><button class="btn btn-danger removeItem" data-item-id="${item.item_id}">X</button></td>
                </tr>
            `;
            })

            tableBody += `<tr><td colspan="4"><button class='btn btn-info text-center' id="btnSendRequest">Send request</button></td</tr>`

            $("#tb").html(tableBody)
        }
    });

    $(document).on("click", ".removeItem", function(e) {
        var item_id = $(this).attr("data-item-id");
        requestArray = requestArray.filter((item) => item.item_id !==item_id);

        tableBody = ""
            var sn = 0;
            requestArray.forEach((item) =>{
                sn++;
                tableBody +=`
                <tr>
                    <td>${sn}</td>
                    <td>${item.itemName}</td>
                    <td>${item.quantity} ${item.unit}</td>
                    <td><button class="btn btn-danger removeItem" data-item-id="${item.item_id}">X</button></td>
                </tr>
            `;
            })

            tableBody += `<tr><td colspan="4"><button class='btn btn-info text-center' id="btnSendRequest">Send request</button></td</tr>`

            $("#tb").html(tableBody)
    })

    $(document).on("click", "#btnSendRequest", function(e) {
        $(this).text("Sending request please wait...")
        $(this).attr("disabled",true);

        if (confirm("Are you you want to send this request?")) {
            $.ajax({
                url: "/api/pr/send-request",
                method: "POST",
                data: {"items":JSON.stringify(requestArray)},
                success: function (response,x) {
                    if (x == 'success') {
                        $(this).text("Send request")
                        alert(response)
                        location.reload()
                    }
                }, error: function(xhr, status, error) {
                    // Request encountered an error
                    console.log('Error');
                    console.log('Status Code: ' + xhr.status);
                    console.log('Error: ' + error);
                },
            })
        }
       
    });
    $(document).on("click", "#addToStock", function(e) {
        $('#errorTxt').text("");

        var item_id = $('#product_id').val();
        // var itemName = $("#product_id").find(":selected").text();
        var itemName = $("#product_id").find(":selected").data("name");
        var quantity = $('#quantity').val();
        var code = $('#code').val();
        var user = $('#user').val();


        var isExisting = stockArray.some(function(item) {
            return item.item_id === item_id;
        });

        if (isExisting) {
            $('#errorTxt').text("Item already exists.");
        } else if (quantity <1) {
            $('#errorTxt').text("Quantity cannot be less than 1.");

        }
        else {
            stockArray.push({ item_id: item_id, itemName, quantity: quantity, code: code,user });

            tableBody = ""
            var sn = 0;
            stockArray.forEach((item) =>{
                sn++;
                tableBody +=`
                <tr>
                    <td>${sn}</td>
                    <td>${item.itemName}</td>
                    <td>${item.quantity}</td>
                    <td><button class="btn btn-danger removeStockItem" data-item-id="${item.item_id}">X</button></td>
                </tr>
            `;
            })

            tableBody += `<tr><td colspan="4"><button class='btn btn-info text-center' id="btnAddToStock">Save</button></td</tr>`

            $("#tb").html(tableBody)
        }
    });
    $(document).on("click", ".removeStockItem", function(e) {
        var item_id = $(this).attr("data-item-id");
        stockArray = stockArray.filter((item) => item.item_id !==item_id);

        tableBody = ""
            var sn = 0;
            stockArray.forEach((item) =>{
                sn++;
                tableBody +=`
                <tr>
                    <td>${sn}</td>
                    <td>${item.itemName}</td>
                    <td>${item.quantity}</td>
                    <td><button class="btn btn-danger removeItem" data-item-id="${item.item_id}">X</button></td>
                </tr>
            `;
            })

            tableBody += `<tr><td colspan="4"><button class='btn btn-info text-center' id="btnSendRequest">Send request</button></td</tr>`

            $("#tb").html(tableBody)
    })
    $(document).on("click", "#btnAddToStock", function(e) {
        $(this).text("Sending request please wait...")
        $(this).attr("disabled",true);


        if (confirm("Are you you want to add these items to stock?")) {
            $.ajax({
                url: "/api/pr/add-to-stock",
                method: "POST",
                data: {"items":JSON.stringify(stockArray)},
                success: function (response,x) {
                    if (x == 'success') {
                        $(this).text("Send request")
                        alert(response)
                        location.reload()
                    }
                }, error: function(xhr, status, error) {
                    // Request encountered an error
                    console.log('Error');
                    console.log('Status Code: ' + xhr.status);
                    console.log('Error: ' + error);
                },
            })
        }
       
    })
    $(document).on("click", "#addService", function(e) {
        $('#errorTxt').text("");

        var item_id = $('#service_id').val();
        // var itemName = $("#product_id").find(":selected").text();
        var itemName = $("#service_id").find(":selected").data("name");

        var quantity = $('#quantity').val();
        var selling_price = $('#service_id').find(":selected").attr("data-selling-price");
        

        var isExisting = sellItemArray.some(function(item) {
            return item.item_id === item_id;
        });

        if (isExisting) {
            $('#errorTxt').text("Item already exists.");
        } else if (quantity <1) {
            $('#errorTxt').text("Quantity cannot be less than 1.");

        }else if (item_id == undefined) {
            $('#errorTxt').text("Item cannot be blank"); 
          }
        else {
            sellItemArray.push({ item_id: item_id, itemName:itemName, quantity: quantity,selling_price : selling_price});

            tableBody = ""
            var sn = 0;
            sellItemArray.forEach((item) =>{
                sn++;
                totalCost +=parseInt((item.selling_price*item.quantity));

                tableBody +=`
                <tr>
                    <td>${sn}</td>
                    <td>${item.itemName}</td>
                    <td>${item.quantity}</td>
                    <td>&#8358;${item.selling_price}</td>
                    <td>&#8358;${item.selling_price*item.quantity}</td>
                    <td><button class="btn btn-danger btn-sm removeSellItem" data-item-id="${item.item_id}">x</button></td>
                </tr>
            `;
            })


            tableBody += `
                <tr>
                    <td colspan="4" class="text-right text-danger"><h5 class="m-1">Total:</h5></td>
                    <td colspan="2" class="text-left text-danger"> <h5 class="m-1">&#8358;${totalCost.toLocaleString()}</h5></td
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Payment Status:</b></td>
                    <td colspan="2"> <input type="radio" class="form-control" checked name="status" id="status" value="PAID"/>PAID</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Mode of Payment:</b></td>
                    <td colspan="1"><input type="radio" class="form-control" checked name="mode" id="mode" value="CASH"/>CASH</td>
                    <td colspan="1"><input type="radio"class="form-control" name="mode" id="mode" value="POS"/>POS</td>
                    <td colspan="2"><input type="radio" class="form-control" name="mode" id="mode" value="TRANSFER"/>TRANSFER</td>
                </tr>
                <tr>
                    <td colspan="6"><button class='btn btn-success text-center m-2' id="btnSaveInvoice2">Save & Print Receipt</button></td
                </tr>
                `;

            $("#tb").html(tableBody)
        }
    });

    $(document).on("click", "#addToSell", function(e) {
        $('#errorTxt').text("");

        var item_id = $('#product_id').val();
        // var itemName = $("#product_id").find(":selected").text();
        var itemName = $("#product_id").find(":selected").data("name");

        var quantity = $('#quantity').val();
        var selling_price = $('#product_id').find(":selected").attr("data-selling-price");
        var stock = $('#product_id').find(":selected").data("stock");
        totalCost=0;


        var isExisting = sellItemArray.some(function(item) {
            return item.item_id === item_id;
        });

        if (isExisting) {
            $('#errorTxt').text("Item already exists.");
        } else if (quantity <1) {
            $('#errorTxt').text("Quantity cannot be less than 1.");

        }else if (item_id == undefined) {
            $('#errorTxt').text("Item cannot be blank"); 
        }else if (quantity > stock) {
            $('#errorTxt').text("Out of stock. Please review quantity. Quantity in stock:"+stock); 
        }
        else {
            sellItemArray.push({ item_id: item_id, itemName:itemName, quantity: quantity,selling_price : selling_price});

            tableBody = ""
            var sn = 0;
            sellItemArray.forEach((item) =>{
                sn++;
                totalCost +=parseInt((item.selling_price*item.quantity));

                tableBody +=`
                <tr>
                    <td>${sn}</td>
                    <td>${item.itemName}</td>
                    <td>${item.quantity}</td>
                    <td>&#8358;${item.selling_price}</td>
                    <td>&#8358;${item.selling_price*item.quantity}</td>
                    <td><button class="btn btn-danger btn-sm removeSellItem" data-item-id="${item.item_id}">x</button></td>
                </tr>
            `;
            })


            tableBody += `
                <tr>
                    <td colspan="4" class="text-right text-danger"><h5 class="m-1">Total:</h5></td>
                    <td colspan="2" class="text-left text-danger"> <h5 class="m-1">&#8358;${totalCost.toLocaleString()}</h5></td
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Payment Status:</b></td>
                    <td colspan="2"> <input type="radio" class="form-control" checked name="status" id="status" value="PAID"/>PAID</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Mode of Payment:</b></td>
                    <td colspan="1"><input type="radio" class="form-control" checked name="mode" id="mode" value="CASH"/>CASH</td>
                    <td colspan="1"><input type="radio"class="form-control" name="mode" id="mode" value="POS"/>POS</td>
                    <td colspan="2"><input type="radio" class="form-control" name="mode" id="mode" value="TRANSFER"/>TRANSFER</td>
                </tr>
                <tr>
                    <td colspan="6"><button class='btn btn-success text-center m-2' id="btnSaveInvoice">Save & Print Receipt</button></td
                </tr>
                `;

            $("#tb").html(tableBody)
        }
    });
    $(document).on("click", ".removeSellItem", function(e) {
        e.preventDefault()
        var item_id = $(this).attr("data-item-id");
       
        sellItemArray = sellItemArray.filter((item) => item.item_id !==item_id);

        totalCost = 0;

        tableBody = ""
            var sn = 0;
            sellItemArray.forEach((item) =>{
                totalCost +=parseInt((item.selling_price*item.quantity));
                
                
                sn++;
                tableBody +=`
                <tr>
                    <td>${sn}</td>
                    <td>${item.itemName}</td>
                    <td>${item.quantity}</td>
                    <td>${item.selling_price}</td>
                    <td>${item.selling_price*item.quantity}</td>
                    <td><button class="btn btn-sm btn-danger removeSellItem" data-item-id="${item.item_id}">x</button></td>
                </tr>
            `;
            })

            tableBody += `
                <tr>
                    <td colspan="4" class="text-right text-danger"><h5 class="m-1">Total:</h5></td>
                    <td colspan="2" class="text-left text-danger"> <h5 class="m-1">&#8358;${totalCost.toLocaleString()}</h5></td
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Payment Status:</b></td>
                    <td colspan="2"> <input type="radio" class="form-control" checked name="status" id="status" value="PAID"/>PAID</td>
                    
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Mode of Payment:</b></td>
                    <td colspan="1"><input type="radio" class="form-control" checked name="mode" id="mode" value="CASH"/>CASH</td>
                    <td colspan="1"><input type="radio"class="form-control" name="mode" id="mode" value="POS"/>POS</td>
                    <td colspan="2"><input type="radio" class="form-control" name="mode" id="mode" value="TRANSFER"/>TRANSFER</td>
                </tr>
                <tr>
                    <td colspan="6"><button class='btn btn-info text-center m-2' id="btnSaveInvoice">Save & Print Receipt</button></td
                </tr>
            `;
            $("#tb").html(tableBody)
    })
    $(document).on("click", "#btnSaveInvoice2", function(e) {
        $(this).text("Saving  please wait...")
        var status = $('input[name="status"]:checked').val();
        var mode = $('input[name="mode"]:checked').val();
        var customer = $('#customer').val() ? $('#customer').val() : null;
        var user = $('#user').val();
        //console.log(customer);
        $(this).attr("disabled",true);


        if (confirm("Are you you want to submit this invoice?")) {
            $.ajax({
                url: "/api/cashier/save-service-invoice",
                method: "POST",
                data: {"items":JSON.stringify(sellItemArray),"status":status,"mode":mode,"user":user,"customer":customer},
                success: function (response,x) {
                    console.log(response);
                    if (x == 'success') {
                        $("#tb").html("")
                        printReceipt(response.items,response.invoice,response.date,response.status,response.customer,response.chasier_name)
                        reset();
                        $("#quantity").val("")
                        $("#customer").val("")
                        $("#service_id").val("")
                        location.reload();


                        // location.reload()
                    }
                }, error: function(xhr, status, error) {
                    // Request encountered an error
                    console.log('Error');
                    console.log('Status Code: ' + xhr.status);
                    console.log('Error: ' + error);
                },
            })
        }
       
    })
    
        $(document).on("click", "#btnSaveInvoice3", function(e) {
           
        $(this).text("Saving  please wait...")
        var status = $('input[name="status"]:checked').val();
        var mode = $('input[name="mode"]:checked').val();
        var customer = $('#customer').val() ? $('#customer').val() : null;
        var user = $('#user').val();
        var amount = $('#amount').val();
        //console.log(customer);
        $(this).attr("disabled",true);
        var scripts = document.getElementsByTagName("script");
        var src = scripts[scripts.length - 1].src;
        
        console.log("This is the URL of the script: " + src);


        if (confirm("Are you you want to submit this invoice?")) {
            $.ajax({
                url: "/api/cashier/save-pharmacy-service-invoice",
                method: "POST",
                data: {"items":'Pharmacy Service',"status":status,"mode":mode,"user":user,"customer":customer, "amount":amount},
                success: function (response,x) {
                    console.log(response);
                    if (x == 'success') {
                        $("#tb").html("")
                        printPReceipt(response.items,response.invoice,response.date,response.status,response.customer,response.chasier_name,response.total_amount)
                        reset();
                        $("#quantity").val("")
                        $("#customer").val("")
                        $("#service_id").val("")
                        location.reload();


                        // location.reload()
                    }
                }, error: function(xhr, status, error) {
                    // Request encountered an error
                    console.log('Error');
                    console.log('Status Code: ' + xhr.status);
                    console.log('Error: ' + error);
                },
            })
        }
       
    })

    $(document).on("click", "#btnSaveInvoice", function(e) {
        $(this).text("Saving  please wait...")
        var status = $('input[name="status"]:checked').val();
        var mode = $('input[name="mode"]:checked').val();
        var user = $('#user').val();

        $(this).attr("disabled",true);


        if (confirm("Are you you want to submit this invoice?")) {
            $.ajax({
                url: "/api/cashier/save-invoice",
                method: "POST",
                data: {"items":JSON.stringify(sellItemArray),"status":status,"mode":mode,"user":user},
                success: function (response,x) {
                    if (x == 'success') {
                        $("#tb").html("")
                        printReceipt(response.items,response.invoice,response.date,response.status)
                        reset();
                        $("#quantity").val("")
                        $("#product_id").val("")
                        location.reload();


                        // location.reload()
                    }
                }, error: function(xhr, status, error) {
                    // Request encountered an error
                    console.log('Error');
                    console.log('Status Code: ' + xhr.status);
                    console.log('Error: ' + error);
                },
            })
        }
       
    })

    $(document).on("click", ".servicereprint", function(e) {
        var status = $(this).data("status")
        var invoice = $(this).data("invoice")
        var date = $(this).data("date")
        var invoice_type = $(this).data("invoice_type")
        // items = JSON.parse(items)
       // console.log(invoice_type);
        $.ajax({
            //url: (invoice_type == '2') ? "/api/cashier/print-service-invoice" : "/api/cashier/print-pharmacy-service-invoice",
            url: "/api/cashier/print-service-invoice",
            method: "POST",
            data: {"invoice":invoice},
            success: function (response,x) {
                //console.log(response);
                if (x == 'success') {
                    $("#tb").html("")
                    printReceipt(response.items,invoice,date,status,response.customers,response.chasier_name,response.amount_paid)
                    reset();
                    $("#quantity").val("")
                    $("#product_id").val("")


                    // location.reload()
                }
            }, error: function(xhr, status, error) {
                // Request encountered an error
                console.log('Error');
                console.log('Status Code: ' + xhr.status);
                console.log('Error: ' + error);
            },
        })
        // alert(items)
    })
    $(document).on("click", ".pservicereprint", function(e) {
        var status = $(this).data("status")
        var invoice = $(this).data("invoice")
        var date = $(this).data("date")
        var invoice_type = $(this).data("invoice_type")
        // items = JSON.parse(items)
       // console.log(invoice_type);
        $.ajax({
            url: "/api/cashier/print-pharmacy-service-invoice",
            method: "POST",
            data: {"invoice":invoice},
            success: function (response,x) {
                //console.log(response);
                if (x == 'success') {
                    $("#tb").html("")
                    printPReceipt(response.items,invoice,date,status,response.customers,response.chasier_name,response.amount_paid)
                    reset();
                    $("#quantity").val("")
                    $("#product_id").val("")


                    // location.reload()
                }
            }, error: function(xhr, status, error) {
                // Request encountered an error
                console.log('Error');
                console.log('Status Code: ' + xhr.status);
                console.log('Error: ' + error);
            },
        })
        // alert(items)
    })


    $(document).on("click", ".reprint", function(e) {
        var status = $(this).data("status")
        var invoice = $(this).data("invoice")
        var date = $(this).data("date")

        // items = JSON.parse(items)
        $.ajax({
            url: "/api/cashier/print-invoice",
            method: "POST",
            data: {"invoice":invoice},
            success: function (response,x) {
                console.log(response);
                if (x == 'success') {
                    $("#tb").html("")
                    printReceipt(response.items,invoice,date,status,response.customers,response.chasier_name,response.amount_paid)
                    reset();
                    $("#quantity").val("")
                    $("#product_id").val("")


                    // location.reload()
                }
            }, error: function(xhr, status, error) {
                // Request encountered an error
                console.log('Error');
                console.log('Status Code: ' + xhr.status);
                console.log('Error: ' + error);
            },
        })
        // alert(items)
    })

    // AGENT SELL
    $(document).on("click", "#addToSellAgent", function(e) {
        $('#errorTxt').text("");

        var item_id = $('#product_id').val();
        var itemName = $("#product_id").find(":selected").data("name");
        var quantity = $('#quantity').val();
        var selling_price = $('#product_id').find(":selected").data("wholesale-price");
        var stock = $('#product_id').find(":selected").data("stock");

        totalCost=0;


        var isExisting = sellItemArray.some(function(item) {
            return item.item_id === item_id;
        });

        if (isExisting) {
            $('#errorTxt').text("Item already exists.");
        } else if (quantity <1) {
            $('#errorTxt').text("Quantity cannot be less than 1.");

        }else if (item_id == undefined) {
            $('#errorTxt').text("Item cannot be blank"); 
        }
        else if (quantity > stock) {
            $('#errorTxt').text("Out of stock. Please review quantity. Quantity in stock:"+stock); 
        }
        else {
            sellItemArray.push({ item_id: item_id, itemName:itemName, quantity: quantity,selling_price : selling_price});

            tableBody = ""
            var sn = 0;
            sellItemArray.forEach((item) =>{
                sn++;
                totalCost +=parseInt((item.selling_price*item.quantity));

                tableBody +=`
                <tr>
                    <td>${sn}</td>
                    <td>${item.itemName}</td>
                    <td>${item.quantity}</td>
                    <td>&#8358;${item.selling_price}</td>
                    <td>&#8358;${item.selling_price*item.quantity}</td>
                    <td><button class="btn btn-danger btn-sm removeSellItem" data-item-id="${item.item_id}">x</button></td>
                </tr>
            `;
            })


            tableBody += `
                <tr>
                    <td colspan="4" class="text-right text-danger"><h5 class="m-1">Total:</h5></td>
                    <td colspan="2" class="text-left text-danger"> <h5 class="m-1">&#8358;${totalCost.toLocaleString()}</h5></td
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Payment Status:</b></td>
                    <td colspan="1"> <input type="radio" class="form-control" checked name="status" id="status" value="PAID"/>PAID</td>
                    <td colspan="2"><input type="radio" class="form-control" name="status" id="status" value="CREDIT"/>CREDIT</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Mode of Payment:</b></td>
                    <td colspan="1"><input type="radio" class="form-control" checked name="mode" id="mode" value="CASH"/>CASH</td>
                    <td colspan="1"><input type="radio"class="form-control" name="mode" id="mode" value="POS"/>POS</td>
                    <td colspan="2"><input type="radio" class="form-control" name="mode" id="mode" value="TRANSFER"/>TRANSFER</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Amount Paid</b></td>
                    <td colspan="4"><input type="number" class="form-control" name="amount_paid" id="amount_paid" value="0"/></td>
                </tr>
                <tr>
                    <td colspan="6"><button class='btn btn-success text-center m-2' id="btnSaveInvoiceAgent">Save & Print Receipt</button></td
                </tr>
                `;

            $("#tb").html(tableBody)
        }
    });
    $(document).on("click", ".removeSellItemAgent", function(e) {
        e.preventDefault()
        var item_id = $(this).attr("data-item-id");
       
        sellItemArray = sellItemArray.filter((item) => item.item_id !==item_id);

        totalCost = 0;

        tableBody = ""
            var sn = 0;
            sellItemArray.forEach((item) =>{
                totalCost +=parseInt((item.selling_price*item.quantity));
                
                
                sn++;
                tableBody +=`
                <tr>
                    <td>${sn}</td>
                    <td>${item.itemName}</td>
                    <td>${item.quantity}</td>
                    <td>${item.selling_price}</td>
                    <td>${item.selling_price*item.quantity}</td>
                    <td><button class="btn btn-sm btn-danger removeSellItem" data-item-id="${item.item_id}">x</button></td>
                </tr>
            `;
            })

            tableBody += `
                <tr>
                    <td colspan="4" class="text-right text-danger"><h5 class="m-1">Total:</h5></td>
                    <td colspan="2" class="text-left text-danger"> <h5 class="m-1">&#8358;${totalCost.toLocaleString()}</h5></td
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Payment Status:</b></td>
                    <td colspan="1"> <input type="radio" class="form-control" checked name="status" id="status" value="PAID"/>PAID</td>
                    <td colspan="2"><input type="radio" class="form-control" name="status" id="status" value="CREDIT"/>CREDIT</td>
            
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Mode of Payment:</b></td>
                    <td colspan="1"><input type="radio" class="form-control" checked name="mode" id="mode" value="CASH"/>CASH</td>
                    <td colspan="1"><input type="radio"class="form-control"  name="mode" id="mode" value="POS"/>POS</td>
                    <td colspan="2"><input type="radio" class="form-control" name="mode" id="mode" value="TRANSFER"/>TRANSFER</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><b>Amount Paid</b></td>
                    <td colspan="4"><input type="number" class="form-control" name="amount_paid" id="amount_paid" value="0"/></td>
                </tr>
                <tr>
                    <td colspan="6"><button class='btn btn-info text-center m-2' id="btnSaveInvoiceAgent">Save & Print Receipt</button></td
                </tr>
            `;
            $("#tb").html(tableBody)
    })

    $(document).on("click", "#btnSaveInvoiceAgent", function(e) {
        $(this).text("Saving  please wait...")
        $('#errorTxt').text("");
        $(this).attr("disabled",true);

        var status = $('input[name="status"]:checked').val();
        var mode = $('input[name="mode"]:checked').val();
        var user = $('#user').val();
        var customer = $('#customer').val();
        var amount_paid = $('#amount_paid').val();

        if ($('input[name="status"]:checked').length < 1) {
            $('#errorTxt').text("Select payment status.");
        } else if ($('input[name="mode"]:checked').length  < 1) {
            $('#errorTxt').text("Select mode of payment.");
        }


        if (confirm("Are you you want to submit this invoice?")) {
            $.ajax({
                url: "/api/cashier/save-invoice-agent",
                method: "POST",
                data: {"items":JSON.stringify(sellItemArray),"status":status,"mode":mode,"user":user,"customer": customer,"amount_paid":amount_paid},
                success: function (response,x) {
                    if (x == 'success') {
                        $("#tb").html("")
                        printReceipt(response.items,response.invoice,response.date,response.status,response.customer,response.amount_paid)
                        reset();
                        $("#quantity").val("")
                        location.reload();
                    }
                }, error: function(xhr, status, error) {
                    // Request encountered an error
                    console.log('Error');
                    console.log('Status Code: ' + xhr.status);
                    console.log('Error: ' + error);
                },
            })
        }
       
    })

    
    
})