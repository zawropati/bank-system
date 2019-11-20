

  $('form').submit(function(){
    $(this).find('input[data-validate=yes]').each( function(){
      $(this).removeClass('invalid')
      let sDataType = $(this).attr('data-type') 
      let iMin = $(this).attr('data-min')
      let iMax = $(this).attr('data-max')
      switch(sDataType){
        case "string":
          if( $(this).val().length < iMin || $(this).val().length > iMax){
              $(this).addClass('invalid')
          }
        break
   
        default:
        console.log('Server error!')
        break
   
      }
    })
   
    if($(this).children().hasClass('invalid')){
      return false
    }
   })
   