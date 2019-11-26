// aqui vamos iniciar o desenvolvimento
$(document).ready(function () {


    //chama a funçao que inicializa os combos de data 
    iniciaCombosDataHora();
     //////////////////////////////////////////////////////////////////
    carregaComboEspecialidades();




     $("#btn-incluir").click(function(){
         incluirLinha(
             "Pendente",
             $("#in-paciente").val(),
             $("#in-espec").val(),
             $( "#in-espec option:selected" ).text(),
             $("#in-med").val(),
             $( "#in-med option:selected" ).text(),
             $("#in-dia").val()+"/"
               + ("00" + (arraymeses.indexOf($("#in-mes").val())+1)).slice(-2)
               +"/"+$("#in-ano").val()+" "+$("#in-hora").val()
         );  
     })

     

     $("#in-espec").change(function () {
       carregaMedicos($(this).val());
     })


     $("#btn-sync").click(function(){

       $("tr.novo").each(function (key,item){
          console.log(item) 
          incluirAgendamentoBD(this,item)

       })

       $("tr.remover").each(function (key,item){
          console.log(item) 
          removerAgendamentoBD(this,item)
          

       })

     })
     
     
    
     // tudo definido ent~ao retira o loader e mostra a tela
     $("#loader").hide();
     $("#main").show();

  });

 

