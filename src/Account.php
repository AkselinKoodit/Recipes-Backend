<?php


namespace App;


class Account
{
    private $balance;
    private $id;

    public function __construct($balance, $id) {
        $this->balance=$balance;
        $this->id=$id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function deposit($amount) {
        if($amount<=0) {
            return "Amount to deposit has to be more than 0";
        } else {
            $this->balance=$this->balance+$amount;
            return "New balance: ".$this->balance;
        }
    }
    public function withdraw($amount) {
        if($amount<=0||$amount>$this->balance) {
            return "Amount to withdraw has to be more than 0 and less than current balance";
        } else {
            $this->balance=$this->balance-$amount;
            return "New balance: " . $this->balance;
        }
    }
    //get balance of 'this' account
    public function getBalance() {
        return $this->balance;
    }
}