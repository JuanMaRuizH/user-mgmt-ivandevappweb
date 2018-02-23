<?php
namespace App;

use \PDO as PDO;

class Cuadro
{
    private $id;
    private $titulo;
    private $imagen;

    public static function recuperaCuadrosPorPintorId(PDO $bd, int $pintorId) : array
    {
        $sql = 'select * from cuadros where pintor_fk=:id';
        $sthSql = $bd->prepare($sql);
        $sthSql->execute([":id" => $pintorId]);
        $sthSql->setFetchMode(PDO::FETCH_CLASS, Cuadro::class);
        $cuadros = $sthSql->fetchAll();
        return $cuadros;
    }


    public function getTitulo() : string
    {
        return $this->titulo;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getImagen() : string
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
}
