
const arraymeses = Array("Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez")


function iniciaCombosDataHora() {
    // combo de anos
    var anoatual = new Date().getYear() + 1900;
    for (a=anoatual;a<anoatual+2;a++) {
       $("#in-ano").append("<option value='"+a+"'>"+a+"</option>");
    }

    // combo de meses
    var mesatual = new Date().getMonth(); 
    var selecionado = "";

    $.each(arraymeses, function (chave,valor){
        if (chave == mesatual) { selecionado = " selected "; } else { selecionado = ""; }  
        $("#in-mes").append("<option "+selecionado+" value='"+valor+"'>"+valor+"</option>");
    })

    
    // combo de dias
    var diaatual = new Date().getDate(); 
    selecionado = "";

    for (var d=1;d<32;d++) {
       if (d == diaatual) { selecionado = " selected "; } else { selecionado = ""; }    
       var dia = ("00"+d).slice(-2); 
       $("#in-dia").append("<option "+selecionado+" value='"+dia+"'>"+dia+"</option>");
    }
    
     

     // combo de horas
     var arrayhoras = Array();
     for (var h=8;h<20;h++) {
         for (var m=0;m<60;m=m+15){
             var hora = ("00"+h).slice(-2)+":"+("00"+m).slice(-2);
             arrayhoras.push("<option value='"+hora+"'>"+hora+"</option>");                      
         }
     }
     $("#in-hora").append(arrayhoras.join("\n"));


     

}


function incluirLinha(
    status,
    nome_paciente,
    codigo_especialidade,
    nome_especialidade,
    id_medico,
    nome_medico,
    datahora
) {
    var uid = "x" + new Date().valueOf();
    var linha =
         "<tr id='"+uid+"' class='novo'>"
         +  "<td data-status>"+status+"</td>"
         +  "<td data-pac>"+nome_paciente+"</td>"
         +  "<td data-esp='"+codigo_especialidade+"'>"+nome_especialidade+"</td>" 
         +  "<td data-med='"+id_medico+"'>"+nome_medico+"</td>"
         +  "<td data-datahora>"+datahora+"</td>"
         +  "<td><button onclick='removerLinha(\""+uid+"\")'>Excluir</button></td>"
         + "</tr>"

    $("#tb-lista > tbody").append(linha);
   }

   function removerLinha(id) {
    if ($("#"+id).hasClass("novo")) {
        $("#"+id).remove();
    } else    
    if ($("#"+id).hasClass("salvo")) {
        $("#"+id).removeClass("salvo");
         $("#"+id).addClass("remover");
       } 
   }


   function carregaComboEspecialidades() {
    $.get("crud.php", { action : "listEspecialidades"  })
     .done(data => {
         $("#in-espec").empty();
         console.log(data);
         $.each(JSON.parse(data), function (key, item) {
         //console.log(item.codigo);
         $('#in-espec').append(
             $('<option></option>').val(item.codigo).html(item.nome)
           )
         });
         //$("#in-espec").val("PED");

         console.log($('#in-espec'));
         console.log($('#in-espec').val())
         carregaComboMedicos($("#in-espec ").val());

      }
    );
}

function carregaComboMedicos(e) {
    params = {}
    params.action= "listMedicos"
    params.espec= e
    

    $.get("crud.php", params)
     .done(data => {
         $("#in-med").empty();
         $.each(JSON.parse(data), function (key, item) {
         //console.log(item);
           $('#in-med').append(
             $('<option></option>').val(item.id).html(item.nome)
           )
         });
      }
    );
}

  


function incluirAgendamentoBD(linha,coluna){
    var params = {}
    params.action = "insertAgendamento";
    params.uid = $(linha).attr("id");
    params.esp = $(coluna).find("td[data-esp]").attr("data-esp");
    params.pac = $(coluna).find("td[data-pac]").text();
    params.med = $(coluna).find("td[data-med]").attr("data-med");
    params.datahora = $(coluna).find("td[data-datahora]").text();
    console.log(params)
    $.post("crud.php", params)
     .done(function(data){
         console.log('data:',data)
         var res = JSON.parse(data);
         console.log('res:',res)
         $(linha).removeClass("novo");
         $(linha).addClass("salvo");
         $(linha).find("[data-status]").text("salvo");
         $(linha).attr("dbid",res.dbid)
         return true;
         })
     .fail(function (data){
         console.log('fail',data)
         return false;
         })
}

function removerAgendamentoBD(linha,coluna){
    var params = {}
    params.action = "deleteAgendamento";
    params.bdid = $(linha).attr("dbid");

}
