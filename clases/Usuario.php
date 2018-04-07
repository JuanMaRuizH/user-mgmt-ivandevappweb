<?php

namespace App;

use \PDO as PDO;

class Usuario
{
    private $id;
    private $identificador;
    private $nombre;
    private $apellidos;
    private $genero;
    private $ocupacion;
    private $clave;
    private $email;
    private $pintor;

    public static function recuperaUsuarioPorCredencial(PDO $bd, string $identificador, string $clave): ?Usuario
    {
        $sql = 'select * from usuarios where identificador=:identificador and clave=:clave';
        $sth = $bd->prepare($sql);
        $sth->execute([":identificador" => $identificador, ":clave" => $clave]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Usuario::class);
        $usuario = ($sth->fetch()) ?: null;
        if ($usuario) {
            $usuario->setPintor(Pintor::recuperaPintorPorId($bd, $usuario->pintor_fk));
        }
        return $usuario;
    }

    public function __construct(string $identificador = null, string $clave = null, string $nombre = null, string $email = null, string $pintorNombre = null)
    {
        if (!is_null($identificador)) {
            $this->identificador = $identificador;
        }
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

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getIdentificador(): string
    {
        return $this->identificador;
    }

    public function setIdentificador(string $identificador)
    {
        $this->identificador = $identificador;
    }


    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getOcupacion(): ?string
    {
        return $this->ocupacion;
    }

    public function setOcupacion(string $ocupacion)
    {
        $this->ocupacion = $ocupacion;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero)
    {
        $this->genero = $genero;
    }

    public function getClave(): ?string
    {
        return $this->clave;
    }

    public function setClave(string $clave)
    {
        $this->clave = $clave;
    }

    public function getEmail(): ?string
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
                $sql = "update usuarios set identificador = :identificador, nombre = :nombre, clave = :clave, email = :email, apellidos = :apellidos, genero = :genero, ocupacion = :ocupacion, pintor_fk = :pintor where id = :id";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":identificador" => $this->getIdentificador(), ":nombre" => $this->getNombre(), ":clave" => $this->getClave(), ":email" => $this->getEmail(), ":apellidos" => $this->getApellidos(), ":genero" => $this->getGenero(), ":ocupacion" => $this->getOcupacion(), ":pintor" => $this->getPintor()->getId(), ":id" => $this->id]);
            } else {
                $sql = "insert into usuarios (identificador, clave, pintor_fk) values (:identificador, :clave, :pintor)";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":identificador" => $this->getIdentificador(), ":clave" => $this->getClave(), ":pintor" => $this->getPintor()->getId()]);
                if ($result) {
                    $this->setId((int) $bd->lastInsertId());
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
        $result = $sth->execute([":id" => $this->getId()]);
        return $result;
    }
}
