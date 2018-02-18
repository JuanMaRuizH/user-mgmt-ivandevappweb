<?php

namespace App;

use \PDO as PDO;
use \DS\Vector as Vector;

class Pintor
{
    private $id;
    private $nombre;
    private $cuadros;

    public static function recuperaPintorPorNombre(PDO $bd, string $nombre): ?Pintor
    {
        $sql = 'select * from pintores where nombre=:nombre';
        $sth = $bd->prepare($sql);
        $sth->execute([":nombre" => $nombre]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Pintor::class);
        $pintor = ($sth->fetch()) ?: null;
        if ($pintor) {
            $pintor->setCuadros(new Vector(Cuadro::recuperaCuadrosPorPintorId($bd, $pintor->getId())));
            return $pintor;
        }
    }

 public static function recuperaPintores(PDO $bd): array
    {
        $sql = 'select * from pintores';
        $sth = $bd->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, Pintor::class);
        $pintores = $sth->fetchAll();
        return $pintores;
    }

    public static function recuperaPintorPorId(PDO $bd, int $id): ?Pintor
    {
        $sql = 'select * from pintores where id=:id';
        $sth = $bd->prepare($sql);
        $sth->execute([":id" => $id]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Pintor::class);
        $pintor = ($sth->fetch()) ?: null;
        if ($pintor) {
            $pintor->setCuadros(new Vector(Cuadro::recuperaCuadrosPorPintorId($bd, $pintor->getId())));
        }
        return $pintor;
    }

    public function __construct()
    {
        $this->cuadros = new Vector();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setCuadros($cuadros)
    {
        $this->cuadros = $cuadros;
    }

    public function getCuadros()
    {
        return $this->cuadros;
    }

    public function getCuadroAleatorio()
    {
        return $this->getCuadros()->get(rand(0, count($this->getCuadros()) - 1));
    }
}
