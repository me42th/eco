<?php if(!class_exists('Rain\Tpl')){exit;}?><script type='text/javascript'>
//vinteum.com/ajax-facil-com-jquery/  
  $(document).ready(function() {
    $("#deszipcode").blur(function() {
      $.ajax({
         url: ' ',  //
         success: function(data) { //O HTML é retornado em 'data'
         alert(data); //Se sucesso um alert com o conteúdo retornado pela URL solicitada será exibido.
       }
      });
    });           
  });
</script>