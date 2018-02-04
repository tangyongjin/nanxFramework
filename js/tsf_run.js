
err_file='';
err_line=1;

 

var base_url = window.location.origin+'/';
// alert(base_url)

$( document ).ready(function() {




$('#args_str').on('change', function() {

   set_args_from_log();
});
      container_result = document.getElementById("jsoneditor_result");
      editor_result = new JSONEditor(container_result);
      container_args = document.getElementById("jsoneditor_args");
      editor_args = new JSONEditor(container_args);
      SyntaxHighlighter.all();
});


function render(){
     var element = document.getElementById('php_source');
     SyntaxHighlighter.highlight(element, element);
}

function clear_arg(){
      $('#args_str').val('');
}

 

function php_last_error_log(btn)
{

  $.post(
            base_url+'testrunner/last_php_err/' ,
            null,
            function(data){
               
               $('#php_err_log').html(data.content);
               err_file=data.err_file;
               err_line=data.err_line;
          }).fail(function() {
              alert( "Posting failed." );
          });
          return false;
}

 



function str_to_obj(str){
  eval_str='args_eval='+str;
  eval(eval_str);
  return args_eval;
}

function get_args_from_log_str(){
  args_str=$('#args_str').val();
  args=str_to_obj(args_str);
  return args;
 }



 function set_args_from_log(){
  args=get_args_from_log_str();
  editor_args.set(args) ; 
 }
 

    function getJSON() {
        var json_get = editor_args.get();
        var str_to_show=JSON.stringify(json_get, null, 2);
        return str_to_show;
    }

 function edit_php(){
  $.post(
            base_url+'testrunner/get_php_source_code/',
            {err_file:err_file,err_line:err_line},
            function(data){ 
               $('#backend_src_code').html(data);
               render();

          }).fail(function() {
              alert( "Posting failed." );
          });
          return false;
    }



 function decypt(){

   var  version_to_test = $("#test_version_input").val(); 
   var   args_str=$('#args_str').val();

   $.post(
            base_url+'/game/decypt/',
            {weixin_share:args_str},
            function(data){
               alert(data.decpty);


          }).fail(function() {
              alert( "Posting failed." );
          });
          return false;
    }

function autologin(){
   var  version_to_test = $("#test_version_input").val(); 
    
   $.post(
            base_url+'user/login/',
            {"name":"18600089281","password":"111111"},
            function(data){
              $('#http_sid').html(data.sid);


          }).fail(function() {
              alert( "Posting failed." );
          });
          return false;
    }

   
  
  remote_execute=function (args_to_post) {

     var str1=getJSON();

      if (str1.length<3){
        $("#btn_set_para").trigger("click");
      }
 

 
      $.ajaxSetup({
      beforeSend: function(request) {
       sid=$('#http_sid').html();
      request.setRequestHeader("sid", sid);
          }
      });


      $('#server_html').html('');
      $('#jsoneditor_result').show();
      $('#server_html').show();
      var x= $( "input:checked" );
      var n = $( "input:checked" ).length;
      var function_radio=x[0];
      var controller=function_radio.value;
      selects='#'+function_radio.value+'_methods';
      var method= $(selects).val() ;

      var  version_to_test = $("#test_version_input").val(); 

      
      
     
      if(arguments.length==0){
         var args_str_to_post_str=getJSON();
         var args_to_post=str_to_obj(args_str_to_post_str) ;
      }

      //      args_to_post,


// $.ajax({
// type: "POST",
// url: "ajaxsubmit.php",
// data: dataString,
// cache: false,
// success: function(result){
// alert(result);
// }
// });


      alert('https! remote_execute')
      $.post(
             base_url+controller+'/'+method+'/',
             args_str_to_post_str,
             function(data){ 
            
              if (typeof data == 'object'){
                   if( method=='login'  ){
                          $('#http_sid').html(data.sid);
                   }

                $('#server_html').hide();
                 editor_result.set(data) ;
              }
                else
                { 

                  $('#server_html').html(data);
                  $('#jsoneditor_result').hide();
                }

          }).done(function(d) {
        var response = d;

    }).fail(function(a,b,c) {
              alert( "调用出错." );

               $('#server_html').show();
               $('#server_html').html(a.responseText);
               $('#jsoneditor_result').hide();
 
          });
          return false;
}
 
