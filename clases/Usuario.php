<?php

namespace App;

class Usuario {

    private $id;
    private $nombre;
    private $clave;
    private $email;
    private $pintor;

    public static function recuperarPorCredencial($bd, $nombre, $clave) {
        $sql = 'select * from usuarios where nombre=:nombre and clave=:clave';
        $sth = $bd->prepare($sql);
        $sth->execute([":nombre" => $nombre, ":clave" => $clave]);
        $sth->setFetchMode(\PDO::FETCH_CLASS, '\App\Usuario');
        $usuario = $sth->fetch();
        if ($usuario) {
            $usuario->setPintor(Pintor::recuperaPintorPorId($bd, $usuario->pintor_fk));
        }
        return $usuario;
    }

    static public function construye($bd, $nombre, $clave, $email, $pintorNombre) {
        $usuario = new Usuario($nombre, $clave, $email, $pintorNombre);
        $usuario->setPintor(Pintor::recuperaPintorPorNombre($bd, $pintorNombre));
        return ($usuario);
    }

    public function __construct($nombre = null, $clave = null, $email = null, $pintorNombre = null) {
        if (!is_null($nombre)) {
            $this->nombre = $nombre;
        }
        if (!is_null($clave)) {
            $this->clave = $clave;
        }
        if (!is_null($email)) {
            $this->email = $email;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPintor() {
        return $this->pintor;
    }

    public function setPintor($pintor) {
        $this->pintor = $pintor;
    }

    public function persist($bd) {
        try {
            if ($this->id) {
                $sql = "update usuarios set nombre = :nombre, clave = :clave, email = :email, pintor_fk = :pintor where id = :id";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":nombre" => $this->nombre, ":clave" => $this->clave, ":email" => $this->email, ":pintor" => $this->pintor->getId(), ":id" => $this->id]);
            } else {
                $sql = "insert into usuarios (nombre, clave, email, pintor_fk) values (:nombre, :clave, :email, :pintor)";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":nombre" => $this->nombre, ":clave" => $this->clave, ":email" => $this->email, ":pintor" => $this->pintor->getId()]);
                if ($result)
                    $this->id = (int) $bd->lastInsertId();
            }
            return ($result);
        } catch (\PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function delete($bd) {
        $sql = "delete from usuarios where id = :id";
        $sth = $bd->prepare($sql);
        $result = $sth->execute([":id" => $this->id]);
        return $result;
    }

}
