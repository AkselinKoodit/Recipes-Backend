<?php


namespace App;


class Bank
{
    private $accounts;
    public function __construct()
    {
        $this->accounts = [];
    }
    public function addAccount(Account $account)
    {
        //add this account in the array of banks
        $this->accounts[] = $account;
    }

    public function getAccountById(int $accountId)
    {
        //return thr first account in the array
        //return $this->accounts[0];

        //TODO update so return matching
        $key = array_search($accountId, $this->accounts, true);
        //return $this->accounts[$key];
        for ($i = 0; $i <= count($this->accounts); $i++) {
             if($accountId==$this->accounts[$i]->getId()) {
                return $this->accounts[$i];
            }
        }
    }
}