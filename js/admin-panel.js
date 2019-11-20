
$('.acceptLoan').click( function(){
  $.ajax({
    method : "GET",
    url : 'apis/api-accept-loan',
    data :  {
        "userId" : $('#phone').val(), 
        "loanId" : $('#loanId').val(),
            },
    dataType: "JSON"
  }).
  done( function(jData){
      console.log(jData)
    if(jData.status == 1){
        swal({
          title: jData.message,
          icon: "success"
        }).then(function (){
            location.reload()
        })
    }
    if(jData.status == 0){
        swal({
          text: jData.message,
          icon: "error"
        })
    }

}).
  fail( function(){
    console.log('FATAL ERROR')
  })


  return false
})

                
