<?php

namespace Source\Models;

class Info extends Model
{

    protected static $safe = ["id, created_at, updated_at"];    

    protected static $entity = "info";    

    public function bootstrap($codEnterprise, $keyDocument, $status): ?Info
    {
        $this->cod_enterprise = $codEnterprise;
        $this->key_document = $keyDocument;
        $this->status = $status;
        return $this;

    }

    public function load($id, $columns = "*"): Info
    {
        $load = $this->read("SELECT {$columns} FROM " .self::$entity. " WHERE id = :id ", "id= {$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Chave não encontrado, para o id informado!";
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    public function loadKey($key, $columns = "*"): ?Info
    {
        $load = $this->read("SELECT {$columns} FROM " .self::$entity. " WHERE key_document like :key_document ", "key_document= {$key}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "Chave não encontrado, para o id informado!";
            return null;
        }

        return $load->fetchObject(__CLASS__);
    }

    public function find($key): ?Info
    {
        $find = $this->read("SELECT * FROM " .self::$entity. " WHERE cod_enterprise = :cod_enterprise", "cod_enterprise={$key}");
        if ($this->fail() || !$find->rowCount()){
            $this->message = "Chave não encontrado, para o id informado!";
            return null;
        }
        return $find->fetchObject(__CLASS__);
    }

    public function all($cod, $limit = 50000 , $ofsset = 0, string $columns = "key_document, status")
    {
        $all = $this->read("SELECT {$columns} FROM " .self::$entity. "LIMIT :l OFFSET :o", "l={$limit}&o={$ofsset}");
        if ($this->fail() || !$all->rowCount()){
            $this->message = "Sua consulta não retornou chaves!";
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);

    }

    public function allLimit20($cod, $limit = 20 , $ofsset = 0, string $columns = "key_document, status")
    {
        $all = $this->read("SELECT {$columns} FROM " .self::$entity. " WHERE cod_enterprise = :cod LIMIT :l OFFSET :o", "cod={$cod}&l={$limit}&o={$ofsset}");
        if ($this->fail() || !$all->rowCount()){
            $this->message = "Sua consulta não retornou chaves!";
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);

    }

    public function save(): ?Info
    {
        if(!$this->required()){
            return null;
        }

        /**Keys Update */
        if (!empty($this->id)){
            $id = $this->id;
            $name = $this->read("SELECT id FROM info WHERE key_document = :key_document","key_document={$this->key_document}");

            $this->update(self::$entity, $this->safe(), "id = :id", "id={$id}");
            if ($this->fail()){
                $this->message = "Erro ao atualizar, verifique os dados";
            }

            $this->message = "Chave atualizada com sucesso!";
            
        }
        /**Keys Create */
        if (empty($this->id)){
            if(strlen($this->key_document) != 44){

                $this->message = "Chave com numero de caracteres invalido";
                return null;
            }

            $userId = $this->create(self::$entity, $this->safe());
            if ($this->fail()){
                $this->message = "Erro ao cadastrar, verifique os dados";
            }

            $this->message = "Chave cadastrada com sucesso";
         
        }
        $this->data = $this->read("SELECT * FROM `info` WHERE id = :id", "id={$id}")->fetch();
        return $this;
    }

    public function destroy(): ?Info
    {
        if (!empty($this->id)){
            $this->delete(self::$entity, "id = :id", "id={$this->id}");
        }

        if ($this->fail()){
            $this->message = "Não foi possivel remover a chave";
            return null;
        }

        $this->message = "Chave excluido com sucesso";
        $this->data = null;
        return $this;
    }

    private function required():bool
    {

        if(empty($this->key_document)){
            $this->message = "A chave é obrigatoria!";
            return false;
        }

        return true;

    }


}