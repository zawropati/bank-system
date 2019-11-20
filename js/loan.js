
    $('#frmLoanApply').submit(function(){

        $.ajax({
          // req
          method:"POST",
          url:"apis/api-loan-apply",
          data:$('#frmLoanApply').serialize(),
          dataType: "JSON"
        }).
        done(function(jInnerData){
          // res
          if(jInnerData.status==1){
            swal({
              text: jInnerData.message,
              icon: "success",
            })
          }
          else{
            swal({
              text: "Something went wrong. "+jInnerData.message,
              icon: "warning",
            })
          }
        }).
        fail(function(){
          console.log('error')
        })
       
       
        return false
       })
