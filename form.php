<link rel="stylesheet" href="./css/form.css">

<?php require 'header.php'; ?>

<form action="write.php" method="post" class="form" id="myForm">
    <ol class="side">
        <?php for ($i = 1; $i <= 5; $i++) { ?>
            <li>
                <input id="place<?php echo $i; ?>" name="place<?php echo $i; ?>" type="text" placeholder="物件名">
                <textarea id="address<?php echo $i; ?>" name="address<?php echo $i; ?>" placeholder="住所"></textarea>
                <textarea name="category<?php echo $i; ?>" id="category<?php echo $i; ?>" placeholder="物件の種類"></textarea>
                <textarea id="content<?php echo $i; ?>" name="content<?php echo $i; ?>" placeholder="メモ"></textarea>
            </li>
        <?php } ?>
    </ol>

    <input type="submit" value="保存する"/>
</form>
