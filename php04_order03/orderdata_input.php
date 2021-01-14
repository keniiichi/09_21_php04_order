<?php
session_start();
include('functions.php');
check_session_id();
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap CSS-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


  <title>注文管理（入力画面）</title>
</head>

<body>
  <form action="orderdata_create.php" method="POST">
    <fieldset>
      <legend class="p-3 mb-2 bg-info text-white">発注フォーム（入力画面）</legend>

      <div class="d-flex justify-content-start">
        <div class="p-2 bd-highlight"><a href="orderdata_read.php">発注一覧</a></div>
        <div class="p-2 bd-highlight">見積書作成</div>
        <div class="p-2 bd-highlight">請求書作成</div>
        <div class="p-2 bd-highlight">分析レポート</div>
        <div class="p-2 bd-highlight">チャット</div>
      </div>


      <!-- <a href="orderdata_read.php"></a> -->
      <div>
        発注日: <input type="date" name="purchase_order_date" class="pt3">
      </div>
      <div>
        発注先: <input type="text" name="order_target">
      </div>
      <div>
        商品名: <input type="text" name="product_name">
      </div>
      <div>
        合計発注額: <input type="text" name="total_amount_including_tax">
      </div>
      <div>
        希望納期: <input type="date" name="desired_delivery_date">
      </div>
      <div>
        発注担当: <input type="text" name="order_responsible">
      </div>
      <div>
        ステータス: <input type="text" name="order_status">
      </div>
      <div>
        <button>発注する</button>
      </div>
    </fieldset>
  </form>

  <!-- bootstrap Javascript-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>