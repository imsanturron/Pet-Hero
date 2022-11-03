<?php
    namespace DAO\MYSQL;

    use DAO\MYSQL\IImageDAO as IImageDAO;
    use DAO\MYSQL\QueryType as QueryType;
    use Models\Imagen as Imagen;
    use \Exception as Exception;

    class ImageDao implements \DAO\MYSQL\IImageDao
    {
        private $tableName = "images";

        public function Add(Imagen $image)
        {
            try
            {
                $query = "INSERT INTO " . $this->tableName . " (name)
             VALUES (:name);";

                
                $parameters["name"] = $image->getNombre();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetAll()
        {
            try
            {
                $imageList = array();

                $query = "SELECT imagenId, nombre FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $image = new Imagen();
                    $image->setId($row["imagenId"]);
                    $image->setNombre($row["nombre"]);

                    array_push($imageList, $image);
                }

                return $imageList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        function GetByImageId($imageId)
        {
            try
            {
                $image = null;

                $query = "SELECT * FROM ".$this->tableName." WHERE imagenId = :imagenId";

                $parameters["imagenId"] = $imageId;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);
                
                foreach ($resultSet as $row)
                {                
                    $image = new Imagen();
                    $image->setId($row["imagenId"]);
                    $image->setNombre($row["nombre"]);
                }

                return $image;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }
    }
?>