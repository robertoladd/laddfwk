<html>
    <head>
        <meta charset="utf-8">
        <title>Addresses List</title>
        <link rel="stylesheet" type="text/css" href="<?=$CONFIG['wwwroot']?>/css/styles.css">
    </head>
    <body>
        
        <h1>Addresses List</h1>
        
        <? if (count($addresses)>0){
        echo '<table>';
            echo '<tr>';
                foreach($addresses[0] as $field =>$value){
                    echo '<th>'.$field.'</th>';
                }
            echo '</tr>';
            
            foreach($addresses as $k =>$address){
                echo '<tr>';
                    foreach($address as $field => $value){
                        echo '<td>'.$value.'</td>';
                    }
                echo '</tr>';
            }
        echo '</table>';
        }
        ?>
    </body>
</html>

