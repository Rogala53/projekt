<?php
   $account_1_balance = 500;
   $account_2_balance = 0;

   function addFund($currentBalance, $valueToAdd) {
      return $currentBalance += $valueToAdd;
   }

   function withdraw($currentBalance, $valueToWithdraw) {
      if($currentBalance < $valueToWithdraw) {
         echo "You don't have enough money to withdraw";
         return $currentBalance;
      }
      else {
         return $currentBalance -= $valueToWithdraw;
      }
   }

   function transfer(&$accountToTransferFrom, $valueToTransfer, &$accountToTransferTo) {
      if($accountToTransferFrom < $valueToTransfer) {
         echo "You don't have enough money to transfer";
      } 
      else {
         $accountToTransferFrom -= $valueToTransfer;
         $accountToTransferTo += $valueToTransfer;         
      }
   }

   function investment(&$account, $valueToInvest, $years) {
      if($account < $valueToInvest) {
         echo "You can't invest more than you have";
      }
      else {
         $account -= $valueToInvest;
         $valueToInvest += $valueToInvest * 0.04 * $years;
         $account += $valueToInvest;
      }
      
   }
   
   echo "<div> account 1 balance: ".$account_1_balance."</div><br>";

   $account_1_balance = addFund($account_1_balance,300);

   echo "<div> account 1 balance after adding funds: ".$account_1_balance."</div><br>";

   $account_1_balance = withdraw($account_1_balance, 100);

   echo "<div> account 1 balance after withdraw: ".$account_1_balance."</div><br>";
   echo "<div> account 2 balance before transfer: ".$account_2_balance."</div><br>";

   transfer($account_1_balance, 200, $account_2_balance);

   echo "<div> account 1 balance after transfer: ".$account_1_balance."</div><br>";
   echo "<div> account 2 balance after transfer: ".$account_2_balance."</div><br>";

   investment($account_1_balance, 100, 2);

   echo "<div> account 1 balance after investment: ".$account_1_balance."</div><br>";
?>