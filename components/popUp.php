<div id="popUp" <?php if (isset ($_SESSION['type'])){ echo "class ='" . $_SESSION['type'] ."'";}?>>
    <?php
        if (isset ($_SESSION['response'])){
            echo '<p>' . htmlspecialchars($_SESSION['response']) . '</p>';
        } 
    ?>
    
</div>
    