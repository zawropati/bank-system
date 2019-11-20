// ******************************************************
// ******************************************************
// ******************************************************
// Talk to the server and get the balance of the logged user
// selv invoking functions
function fnvGetBalance(){

  var money = new Audio('money.mp3')

  setInterval( function(){

    $.ajax({
      method : "GET",
      url : 'apis/api-get-balance',
      cache : false
    }).done(function( sBalance ){
      if( sBalance != $('#lblBalance').text()  ){
        $('#lblBalance').text(sBalance)        
        money.play()
      }
    }).fail(function(){})



    $.ajax({
      method : "GET",
      url : 'apis/api-get-transactions',
      cache : false,
      dataType : "JSON"
    }).done(function( jTransactions ){
      $('#lblTransactions').html('')
      
      for( let jTransactionKey in jTransactions ){
        console.log(jTransactionKey)
        let jTransaction = jTransactions[jTransactionKey] // get object from key
        let date = jTransaction.date
        let amount = jTransaction.amount
        let fromPhone = jTransaction.fromPhone
        let message = jTransaction.message
        
        // string literals
        let sTransactionTr = `
          <tr>
            <td>${jTransactionKey}</td>
            <td>${date}</td>
            <td>${amount}</td>
            <td>${fromPhone}</td>
            <td>${message}</td>
          </tr>       
        ` 
        $('#lblTransactions').prepend(sTransactionTr)
        // Maybe display them slower
      }



    }).fail(function(){})





  }, 10000 )
}

fnvGetBalance()






$('#frmTransfer').submit( function(){

  $.ajax({
    method : "GET",
    url : 'apis/api-transfer',
    data :  {
              "phone" : $('#txtTransferToPhone').val(),
              "amount" : $('#txtTransferAmount').val(), 
              "message" : $('#txtTransferMessage').val() 
            },
    cache: false,
    dataType:"JSON"    
  }).
  done( function(jData){
    if(jData.status == -1){
      swal({
        title: jData.message,
        icon: "error"
      })
    }

    if(jData.status == 0){
      swal({
        title: jData.message,
        icon: "warning"
      })    
    }
    if(jData.status == 1){
      swal({
        title: jData.message,
        icon: "success"
      })  
    }   
  }).
  fail( function(){
    console.log('FATAL ERROR')
  })


  return false
})









