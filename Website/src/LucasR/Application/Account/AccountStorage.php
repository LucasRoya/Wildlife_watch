<?php

namespace LucasR\Application\Account;

use LucasR\Application\Account\Account;

interface AccountStorage{
    public function getAccountInfo($username);
    public function getAllAccountRequests();
    public function addFinalAccount($id);
    public function addAccountRequest(Account $account);
    public function deleteAccount($username);
    public function deleteAccountRequest($username);
    public function modifyAccount(Account $account);
}

?>