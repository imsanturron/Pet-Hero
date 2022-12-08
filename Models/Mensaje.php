<?php

namespace Models;

class Mensaje extends chat
{
    private $idM; //PK
    private $idChat; //FK
    private $mensaje;
    private $fecha; // YYYY/MM/DD HH/MM/SS
    private $senderMsj; // char: guardian = 'g' - dueño = 'd' --> quien envio el chat


    public function  __construct($idChat = null, $mensaje = null, $senderMsj = null)
    {
        if (isset($idChat) && isset($mensaje)) {
            $this->idChat = $idChat;
            $this->mensaje = $mensaje;
            $this->fecha = date("Y-m-d H:i:s");
            $this->senderMsj = $senderMsj;
        }
    }

    public function getIdM()
    {
        return $this->idM;
    }

    public function setIdM($idM): self
    {
        $this->idM = $idM;

        return $this;
    }

    public function getIdChat()
    {
        return $this->idChat;
    }

    public function setIdChat($idChat): self
    {
        $this->idChat = $idChat;

        return $this;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function setMensaje($mensaje): self
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getSenderMsj()
    {
        return $this->senderMsj;
    }

    public function setSenderMsj($senderMsj): self
    {
        $this->senderMsj = $senderMsj;

        return $this;
    }
}
