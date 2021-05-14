<?php

namespace App\Controller;

use App\Account;
use App\Bank;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BankAccountController extends AbstractController
{
    #[Route('/bank/account', name: 'bank_account')]
    public function index(): Response
    {
        $bank= new Bank();
        $firstAccount = new Account(1001, 12345);
        $secondAccount = new Account (5000, 123);
        $thirdAccount = new Account (20000, 999);

        $bank->addAccount($firstAccount);
        $bank->addAccount($secondAccount);
        $bank->addAccount($thirdAccount);


        return $this->json([
            'balance' => $bank->getAccountById(12345)->getBalance(),
            'balance of second' => $bank->getAccountById(123)->getBalance(),
            'balance of third' => $bank->getAccountById(999)->getBalance(),
            'Deposit negative amount to third bank: '=>$bank->getAccountById(999)->deposit(-1000), //illegal
            'Legal deposit to third bank 999: '=>$bank->getAccountById(999)->deposit(1000),//legal
            'Trying to withdraw 1000 from second bank: '=>$bank->getAccountById(123)->withdraw(1000),//legal and should deduct 1000
            'Trying to withdraw -1000 from second bank: '=> $bank->getAccountById(123)->withdraw(-10000),//illegal
            'Trying to withdraw 10000 from second bank: '=>$bank->getAccountById(123)->withdraw(10000),//legal but not possible
            'new balance' => $bank->getAccountById(12345)->getBalance(),
            'new balance of second' => $bank->getAccountById(123)->getBalance(),
            'new balance of third' => $bank->getAccountById(999)->getBalance(),
        ]);
    }
}
