<?php

  if (isset ($_SESSION['type'])){ 
    echo '<div id="popUp" class ="' . $_SESSION['type'] . '">';
    
        if (isset ($_SESSION['response'])){
            echo '<p>' .($_SESSION['response']) . '</p>';
        } 
        echo '</div>';
        unset($_SESSION['response']);
        unset($_SESSION['type']);
  }
    ?>
    

    