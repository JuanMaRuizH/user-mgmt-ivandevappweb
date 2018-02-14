<?php
namespace App;

class Cuadro {
    private $id;
    private $titulo;
    private $imagen;

    public static function recuperaCuadrosPorPintorId($bd, $pintorId) {
        $sql = 'select * from cuadros where pintor_fk=:id';
        $sthSql = $bd->prepare($sql);
        $sthSql->execute([":id" => $pintorId]);
        $sthSql->setFetchMode(\PDO::FETCH_CLASS, '\App\Cuadro');
        $cuadros = $sthSql->fetchAll();
        return new \Ds\Vector($cuadros);
    }

    public function __construct() {    
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

}
