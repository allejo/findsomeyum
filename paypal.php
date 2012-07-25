<?
   /*
        Copyright Sujevo Software, 2012. All Rights Reserved.
        http://sujevo.com
        
        Usage of this software is allowed with expressed written
        permission of the owner. This source may not be modified
        or built upon without expressed written permission from
        the copyright holder.
        This software is provided "AS IS" and at no time is the
        developer or distributor of this software liable for
        any damage caused by the use or misuse of the this
        software.
    */

   session_start();

   require_once('admin/includes/mysql_connection.php');
   require_once('admin/includes/auxiliaryFunctions.php');

   $transactionID = $_POST["txn_id"];
   $item = $_POST["item_name1"];
   $amount = $_POST["mc_gross_1"];
   $currency = $_POST["mc_currency"];
   $datefields = $_POST["payment_date"];
   $status = $_POST["payment_status"];
   $firstname = $_POST["first_name"];
   $lastname = $_POST["last_name"];
   $email = $_POST["payer_email"];

   if ($transactionID AND $amount)
   {
      // query to save data
      $myUserID = XiON_getUserIDFromSession($dbc);

      $transactionQuery = "INSERT INTO sales (sale_id, transaction_id, item, amount, currency, payment_date, payment_status, first_name, last_name, email) VALUES (NULL, '$transactionID', '$item', '$amount', '$curreny', '$datefields', '$status', '$firstname', '$lastname', '$email')";
      $insertTransaction = @mysqli_query($dbc, $transactionQuery);
   }
?>