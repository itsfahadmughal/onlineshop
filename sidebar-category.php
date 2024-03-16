<div class="title-left">
    <h3>Categories</h3>
</div>
<div class="list-group list-group-collapse list-group-sm list-group-tree" data-children=".sub-men">
    <div class="list-group-collapse sub-men">
        <?php
                        $i=0;
                        $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++; ?>
        <a class="list-group-item list-group-item-action"
            href="#sub<?php echo $i; ?>" data-toggle="collapse"
            aria-expanded="true" aria-controls="sub-men1"><?php echo $row['tcat_name']; ?>
            <small class="text-muted">(<?php echo get_topcat_product_count($pdo, $result[0]['tcat_id']); ?>)</small>
        </a>
        <?php
            
                $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
                            $statement1->execute(array($row['tcat_id']));
                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC); ?>
        <div class="collapse <?php if (isset($_REQUEST['id'])==$result1[0]['mcat_id']) {
                                echo 'show';
                            } ?>"
            id="sub<?php echo $i; ?>">
            <div class="list-group">
                <?php
                    $j=0;
                            foreach ($result1 as $row1) {
                                $j++; ?>
                <a href="shop.php?id=<?php echo $row1['mcat_id']; ?>&type=sub"
                    class="list-group-item list-group-item-action <?php if (isset($_REQUEST['id']) && $_REQUEST['id']==$row1['mcat_id']) {
                                    echo 'active';
                                } ?>"><?php echo $row1['mcat_name']; ?>
                    <small class="text-muted">(<?php echo get_midcat_product_count($pdo, $result1[0]['mcat_id']); ?>)</small>
                </a>
                <?php
                            } ?>
            </div>
        </div>
        <?php
                        } ?>
    </div>
</div>