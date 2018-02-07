<?php

namespace App;

class Pintor {

    private $id;
    private $nombre;
    private $cuadros;

    public static function getPintorByNombre($bd, $nombre) {
        $sql = 'select * from pintores where nombre=:nombre';
        $sthSql = $bd->prepare($sql);
        $sthSql->execute([":nombre" => $nombre]);
        $sthSql->setFetchMode(\PDO::FETCH_CLASS, '\App\Pintor');
        $pintor = $sthSql->fetch();
        $pintor->setCuadros(Cuadro::getCuadrosByPintorId($bd, $pintor->getId()));
        return $pintor;
    }

    public static function getPintores($bd) {
        $sql = 'select * from pintores';
        $sthSql = $bd->prepare($sql);
        $sthSql->execute();
        $sthSql->setFetchMode(\PDO::FETCH_CLASS, '\App\Pintor');
        $pintores = $sthSql->fetchAll();
        return $pintores;
    }

    public static function getPintorById($bd, $id) {
        $sql = 'select * from pintores where id=:id';
        $sthSql = $bd->prepare($sql);
        $sthSql->execute([":id" => $id]);
        $sthSql->setFetchMode(\PDO::FETCH_CLASS, '\App\Pintor');
        $pintor = $sthSql->fetch();
        $pintor->setCuadros(Cuadro::getCuadrosByPintorId($bd, $pintor->getId()));
        return $pintor;
    }

    public function __construct() {
        $this->cuadros = new \Ds\Vector();
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

    public function setCuadros($cuadros) {
        $this->cuadros = $cuadros;
    }

    public function getCuadros() {
        return $this->cuadros;
    }

    public function getCuadroAleatorio() {
        return $this->getCuadros()->get(rand(0, count($this->getCuadros()) - 1));
    }

    
    
    
}
