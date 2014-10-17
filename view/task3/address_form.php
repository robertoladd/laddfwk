<?
global $CONFIG;
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Address From</title>
        <link rel="stylesheet" type="text/css" href="<?=$CONFIG['wwwroot']?>/css/styles.css">
    </head>
    <body>
        <h1>Address form</h1>
        <div class="container">

            <form action="<?= $CONFIG['wwwroot']?>/t3/address<?=($address->id>0?'/'.$address->id:'')?>.html" content-type="application/json" method="post" class="address_form">
                <label for="name">Name:</label> <input name="name" type="text" value="<?=$address->name?>"/><br>
                <label for="phone_number">Phone:</label> <input name="phone_number" type="text" value="<?=$address->phone_number?>"/><br>
                <label for="address">Address:</label> <input name="address" type="text" value="<?=$address->address?>"/><br>
                <input type="submit" class="save_btn btn-save" value="✔ Save" />
            </form>
        </div>
    </body>
</html>

