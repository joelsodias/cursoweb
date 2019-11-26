<?php


$link = mysqli_connect("localhost", "root", "flybyte", "mesquitaweb201902");



if (isset($_REQUEST["action"])) {
  $action = $_REQUEST["action"];
    switch ($action) {
      case "listMedicos":
        $sql= "select id, nome from medico ";
        $where= (isset($_REQUEST["espec"])) ? " where especialidade = '" . $_REQUEST["espec"] . "'" : ""; 
        //echo $sql . $where;
        
        $res = mysqli_query($link,$sql . $where);
        
        $linhas = array();
        while ( $linha = mysqli_fetch_assoc($res) ) {
          $linhas[] = $linha;
          //print_r($linha);
          //echo "linha";
        }


        echo(json_encode($linhas)); 
      break;


      case "listEspecialidades":
        $sql= "select codigo, nome from especialidade ";
        //echo $sql . $where;
        
        $res = mysqli_query($link,$sql);
        
        $linhas = array();
        while ( $linha = mysqli_fetch_assoc($res) ) {
          $linhas[] = $linha;
        }
        echo(json_encode($linhas)); 
      break;

      case "listAgendamentos":


        
      break;

      case "insertAgendamento":
         $uid = $_REQUEST["uid"];
         $data = date_create_from_format("d/m/Y H:i",$_REQUEST["datahora"], new DateTimeZone('America/Sao_Paulo'));
         $data = date_format($data, 'Y-m-d H:i');
         $esp = $_REQUEST["esp"];
         $pac = $_REQUEST["pac"];
         $med = $_REQUEST["med"]; 
       
         $sql = "insert into agendamento (data_agendamento, especialidade, paciente, medico) " 
              . " values ('$data','$esp','$pac',$med)";

         $ret = mysqli_query($link,$sql);
         if ($ret) {
           $id = mysqli_insert_id($link);
           echo json_encode(array("uid" => $uid, "dbid" => $id, "status" => "sucesso"));
           http_response_code(200);
         } else {
           $msg = mysqli_error($link);
           $msg .= " sql = ". $sql;
           //print_r($_REQUEST);
           echo json_encode(array("uid" => $uid, "status" => "error","message" => $msg)); 
           http_response_code(500);
         }
       break;


      case "deleteAgendamento":break;
      




      default: 
      echo json_encode(array("uid" => $uid, "status" => "error", "message" => "no action defined")); 
      http_response_code(400);
      break;

    }


}