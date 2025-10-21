<?php

namespace App\BaseDatos;

use Exception;
use \PDOException;
use \PDO;

class Usuario extends Conexion
{
    private int $id;
    private string $nombre;
    private string $descripcion;
    private string $email;
    private string $admin;

    // Metodos para el crud Create, Read, Update, Delete
    public function create()
    {
        $q = "insert into usuarios(nombre, email, descripcion, admin) values(:n, :e, :d, :a)";
        $stmt = self::getConexion()->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':e' => $this->email,
                ':d' => $this->descripcion,
                ':a' => $this->admin
            ]);
        } catch (PDOException $ex) {
            throw new Exception("Error en Insert: " . $ex->getMessage());
        }
    }
    public static function read(): array
    {
        $q = "select * from usuarios order by id desc";
        $stmt = self::getConexion()->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            throw new Exception("Error en Select: " . $ex->getMessage());
        }
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function delete(int $id) {}
    // --------------------------------------------------------------- OTROS METODOS
    public static function crearRegistrosRandom(int $cantidad)
    {
        $faker = \Faker\Factory::create('es_ES');
        for ($i = 0; $i < $cantidad; $i++) {
            $nombre = $faker->unique()->userName();
            //$email=$faker->unique()->email();
            $email = $nombre . "@" . $faker->freeEmailDomain();
            $descripcion = $faker->text();
            $admin = $faker->randomElement(['SI', 'NO']);
            $usuario = (new Usuario)->setNombre($nombre)
                ->setDescripcion($descripcion)
                ->setEmail($email)
                ->setAdmin($admin)
                ->create();
        }
    }


    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of admin
     */
    public function setAdmin(string $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
