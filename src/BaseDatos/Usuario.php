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
    public static function delete(int $id)
    {
        $q = "delete from usuarios where id=:i";
        $stmt = self::getConexion()->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            throw new Exception("Error en delete: " . $ex->getMessage());
        }
    }
    public function update(int $id)
    {
        $q = "update usuarios set nombre=:n, email=:e, descripcion=:d, admin=:a where id=:i";
        $stmt = self::getConexion()->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':e' => $this->email,
                ':d' => $this->descripcion,
                ':a' => $this->admin,
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            throw new Exception("Error en Update: " . $ex->getMessage());
        }
    }
    // --------------------------------------------------------------- OTROS METODOS
    public static function getUserById(int $id): bool|Usuario
    {
        $q = "select * from usuarios where id=:i";
        $stmt = self::getConexion()->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            throw new Exception("Error en getUserById: " . $ex->getMessage());
        }
        $consulta = $stmt->fetchAll(PDO::FETCH_CLASS, Usuario::class);
        //devolvera un array o bien vacio o bien con un unico objeto de la clase Usuario
        return count($consulta) ?  $consulta[0] : false;
    }
    public static function existeValor(string $valor, string $campo, ?int $id = null): bool
    {
        // si $id=null vengo de nuevo, si no vengo de update
        $q = ($id == null) ? "select count(*) as total from usuarios where $campo=:v" :
            "select count(*) as total from usuarios where $campo=:v AND id != :i";
        
        $stmt = self::getConexion()->prepare($q);
        $parametros=($id==null) ? [':v' => $valor] : [':v' => $valor, ':i'=>$id];
        try {
            $stmt->execute($parametros);
        } catch (PDOException $ex) {
            throw new Exception("Error en existeValor: " . $ex->getMessage());
        }
        $datos = $stmt->fetchAll(PDO::FETCH_OBJ);
        //var_dump($datos);
        //die();
        return $datos[0]->total; // 0 si no existe el email 1 si si existe;  

    }

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

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * Get the value of admin
     */
    public function getAdmin(): string
    {
        return $this->admin;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
