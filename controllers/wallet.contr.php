<?php
require "../models/wallet.model.php";

class WalletContr extends Wallet
{
    private $walletModel;
    public function __construct(Wallet $walletModel)
    {
        $this->walletModel = $walletModel;
    }
    
    public function viewWalletBalance($user_id)
    {
        return $this->walletModel->getWalletBalance($user_id);
    }
}
