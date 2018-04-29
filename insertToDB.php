<?php
    include 'dbConnection.php';

    function insertToTDB($items) {
        if (!$items) return; 
        
        $db = connectToDB(); 
        
        foreach ($items as $item) {
            $itemName = $item['name']; 
            $itemPrice = $item['salePrice']; 
            $itemImage = $item['thumbnailImage']; 
            
            $sql = "INSERT INTO item (item_id, name, price, image_url) VALUES (NULL, :itemName, :itemPrice, :itemURL)";
            $statement = $db->prepare($sql); 
            $statement->execute(array(
                itemName => $itemName, 
                itemPrice => $itemPrice, 
                itemURL => $itemImage
                ));
        }
    }
?>