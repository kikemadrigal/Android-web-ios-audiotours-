<?php

?>
<div class="m-4">
    <a href='<?php echo PATHSERVER ?>database/show' class='btn btn-outline-primary btn-lg <?php echo $active[0];?>'>TXT</a>
    <a href="<?php echo PATHSERVER ?>database/csv" class="btn btn-outline-secondary btn-lg <?php echo $active[1];?>">CSV</a>
    <a href="<?php echo PATHSERVER ?>database/mysql" class="btn btn-outline-success btn-lg <?php echo $active[2];?>" >MYSQL</a>
    <a href="<?php echo PATHSERVER ?>database/sqlite" class="btn btn-outline-danger btn-lg <?php echo $active[3];?>">sqlite</a>
</div>