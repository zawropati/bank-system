// (function(){
//   alert("aaaa");
//  })();

$('#frmLogin').submit(function(){
      $.ajax({
        method:"POST",
        url:"apis/api-login",
        data:$('#frmLogin').serialize(),
        dataType: "JSON"
      }).
      done(function(jInnerData){
        console.log(jInnerData)
        if(jInnerData.status==1){
          location.href='profile'
          swal({
                text: "You are logged in.",
                icon: "success",
              })
        }else{
          swal({
            title: "Warning",
            text: jInnerData.message,
            icon: "warning",
          })
        }
      }).
      fail(function(){
        console.log('error')
      })
    
    
      return false
    })


    $('#frmForgotPassword').submit(function(){

      $.ajax({
        // req
        method:"POST",
        url:"apis/api-forgot-password",
        data:$('#frmForgotPassword').serialize(),
        dataType: "JSON"
      }).
      done(function(jInnerData){
        // res
        if(jInnerData.status==1){
          swal({
            title:"Forgot password",
            text: "Your password has been changed to: "+jInnerData.message+". Use it to log in and change your password on the profile page.",
            icon: "info",
          })
        }
        else{
          swal({
            title:"Forgot password",
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
     
     $('#forgotPassword').click(function(){
       console.log("clicked")
      $("#frmForgotPassword").show("slow");

     })