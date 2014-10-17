<?php 
    global $CONFIG;
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Addresses Index</title>
        <link rel="stylesheet" type="text/css" href="<?=$CONFIG['wwwroot']?>/css/styles.css">
    </head>
    <body>
        <h1>Addresses Index</h1>
        <div class="container">
            <a class="btn" href="<?=$CONFIG['wwwroot']?>/t3/address/form.html" >✚ New address</a>
            <? if (count($addresses)>0){
            echo '<table>';
                echo '<tr>';
                    foreach($addresses[0] as $field =>$value){
                        echo '<th>'.$field.'</th>';
                    }
                        echo '<th>Actions</th>';
                echo '</tr>';

                foreach($addresses as $k =>$address){
                    echo '<tr>';
                        foreach($address as $field => $value){
                            echo '<td>'.$value.'</td>';
                        }
                        echo '<td class="actions">';
                            echo '<form method="post" id="deleteFrom'.$address->id.'" action="'.$CONFIG['wwwroot'].'/t3/address/'.$address->id.'.html"><input type="hidden" value="delete" name="fake_method"/><input type="button" class="btn-delete" onclick="deleteAddress('.$address->id.');" value="delete ✖"/></form>';
                            echo '<form method="get" action="'.$CONFIG['wwwroot'].'/t3/address/'.$address->id.'/form.html"><input class="btn-edit" type="submit" value="edit ✎"/></form>';
                        echo '</td>';
                    echo '</tr>';
                }
            echo '</table>';
            }
            ?>
            <a class="btn" href="<?=$CONFIG['wwwroot']?>/t3/address/form.html" >✚ New address</a>
        </div>
        <script type="text/javascript" src="<?=$CONFIG['wwwroot']?>/js/task3.js" ></script>
    </body>
</html>

