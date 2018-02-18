<?php

namespace App;

use \PDO as PDO;

class Usuario
{
    private $id;
    private $nombre;
    private $clave;
    private $email;
    private $pintor;

    public static function recuperaUsuarioPorCredencial(PDO $bd, string $nombre, string $clave): ?Usuario
    {
        $sql = 'select * from usuarios where nombre=:nombre and clave=:clave';
        $sth = $bd->prepare($sql);
        $sth->execute([":nombre" => $nombre, ":clave" => $clave]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Usuario::class);
        $usuario = ($sth->fetch()) ?: null;
        if ($usuario) {
            $usuario->setPintor(Pintor::recuperaPintorPorId($bd, $usuario->pintor_fk));
        }
        return $usuario;
    }

    public static function construye(PDO $bd, string $nombre, string $clave, string $email, string $pintorNombre): ?Usuario
    {
        $usuario = new Usuario($nombre, $clave, $email, $pintorNombre);

        $usuario->setPintor(Pintor::recuperaPintorPorNombre($bd, $pintorNombre));
        return ($usuario);
    }

    public function __construct(string $nombre = null, string $clave = null, string $email = null, string $pintorNombre = null)
    {
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

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getClave(): string
    {
        return $this->clave;
    }

    public function setClave(string $clave)
    {
        $this->clave = $clave;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPintor(): Pintor
    {
        return $this->pintor;
    }

    public function setPintor(Pintor $pintor)
    {
        $this->pintor = $pintor;
    }

    public function persiste(PDO $bd) : bool
    {
        try {
            if ($this->id) {
                $sql = "update usuarios set nombre = :nombre, clave = :clave, email = :email, pintor_fk = :pintor where id = :id";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":nombre" => $this->nombre, ":clave" => $this->clave, ":email" => $this->email, ":pintor" => $this->pintor->getId(), ":id" => $this->id]);
            } else {
                $sql = "insert into usuarios (nombre, clave, email, pintor_fk) values (:nombre, :clave, :email, :pintor)";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":nombre" => $this->nombre, ":clave" => $this->clave, ":email" => $this->email, ":pintor" => $this->pintor->getId()]);
                if ($result) {
                    $this->id = (int) $bd->lastInsertId();
                }
            }
            return ($result);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function elimina(PDO $bd) : bool
    {
        $sql = "delete from usuarios where id = :id";
        $sth = $bd->prepare($sql);
        $result = $sth->execute([":id" => $this->id]);
        return $result;
    }
}
