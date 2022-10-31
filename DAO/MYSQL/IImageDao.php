<?php
    namespace DAO\MYSQL;

    use Models\Imagen as Imagen;

    interface IImageDao
    {
        function Add(Imagen $image);
        function GetAll();
        function GetByImageId($imageId);
    }
?>