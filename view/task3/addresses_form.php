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
        
        <form action="<?= $CONFIG['wwwroot']?>/address" method="post">
            <label for="name">Name:</label> <input name="name" type="text" value="<?=$$address->name?>"/><br>
            <label for="phone_number">Phone:</label> <input name="phone_number" type="text" value="<?=$$address->phone_number?>"/><br>
            <label for="address">Address:</label> <input name="address" type="text" value="<?=$$address->address?>"/><br>
            <input type="submit" value="Save" />
        </form>
    </body>
</html>

