$("#login").submit(function(){
$.ajax({
    data: $('#login').serialize(),
    url: "api-test",
    dataType: "JSON",
    method: "POST"

}).done(function(jData){
    if(jData.status == 1){
        alert(jData.message)
    }else{
        alert(jData.message)
    }



}).fail(function(){
    console.log("error")
})


return false

})