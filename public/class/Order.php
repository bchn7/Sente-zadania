<?php

class Order
{
    private $orderRef;
    private $clientName;
    private $registerDate;
    private $orderSymbol;
    private $sendDate;
    private $invoiced;

    public function __construct($orderRef, $clientName, $registerDate, $orderSymbol, $sendDate, $invoiced){
        
        $this->orderRef = $orderRef;
        $this->clientName = $clientName;
        $this->registerDate = $registerDate;
        $this->orderSymbol = $orderSymbol;
        $this->sendDate = $sendDate;
        $this->invoiced = $invoiced;
    }

    public function getOrderRef(){
        return $this->orderRef;
    }

    public function getClientName(){
        return $this->clientName;
    }

    public function getRegisterDate(){
        return $this->registerDate;
    }

    public function getOrderSymbol(){
        return $this->orderSymbol;
    }

    public function getSendDate(){
        return $this->sendDate;
    }
    
    public function isInvoiced(){
        return $this->invoiced;
    }
}