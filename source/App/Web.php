<?php

namespace Source\App;

class Web
{

    public function insert()
    {

        $data = file("/var/www/html/source/tmp/file_keys.txt");

        $model = new \Source\Models\Info();

        foreach ($data as $key => $value) {
            
            $info = explode(";", $value);
            $codeCompany = $info[0];
            $keyDocument = substr($info[1], 0, -2);

            $insert = $model->bootstrap($info[0], $keyDocument, "Pendent");
            $insert->save();             

             if($insert->message() == "Chave cadastrada com sucesso")
             {
                 $message = array("code" => 200, "status" => "success", "content" => array("key" => $keyDocument, "message" => "Chave criada com sucesso!"));
             }
 
             if($insert->message() == "Chave com numero de caracteres invalido")
             {
                 $message = array("code" => 300, "status" => "warning", "content" => array("key" => $keyDocument, "message" => "Numero de caracteres invalido!"));
             }

             print json_encode($message);
 
         }
    }

    public function update()
    {
        
        $data = file("/var/www/html/source/tmp/file_keys.txt");

        $model = new \Source\Models\Info();

        foreach ($data as $key => $value) {
            
            $info = explode(";", $value);
            $codeCompany = $info[0];
            $keyDocument = substr($info[1], 0, -2);
           
            $update = $model->find($info[0]);
            $update->status = "Valid";
            $update->save();

            if($update->message() == "Chave atualizada com sucesso!")
             {
                 $message = array("code" => 200, "status" => "success", "content" => array("key" => $keyDocument, "message" => "Chave atualizada com sucesso!"));
             }
 
             if($update->message() == "Chave com numero de caracteres invalido")
             {
                 $message = array("code" => 300, "status" => "warning", "content" => array("key" => $keyDocument, "message" => "Numero de caracteres invalido!"));
             }            

             print json_encode($message);

        }

    }

    public function list20()
    {

        $model = new \Source\Models\Info();
        $list20 = $model->allLimit20($_GET['cod']);

        foreach ($list20 as $k => $v) {
            $info[] =[
                "Documento" => $v->key_document,
                "Status" => $v->status ];
         
        }

        print json_encode($info, JSON_FORCE_OBJECT);
    }

    public function list()
    {

        $model = new \Source\Models\Info();
        $list = $model->all($_GET['cod']);

        foreach ($list as $k => $v) {
            $info[] =[
                "Documento" => $v->key_document,
                "Status" => $v->status ];
         
        }

        print json_encode($info, JSON_FORCE_OBJECT);
    }

    public function error($data)
    {
        echo "<h1>Erro{$data["errcode"]}</h1>";
         
    }

}