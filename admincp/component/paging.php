<div class="row" style="text-align: right;">
    <ul class="pagination">
        <?php 
            $class="";if($stpage<=1) $class="disabled";
        ?>
        <li class="prev <?php echo $class ?>"><a href="<?php echo cpagerparm("p") ?>p=<?php if($stpage<=1) echo 1 ; else echo $stpage-1 ; ?>">Trước</a></li>
        
        <?php 
            $i = 1;
            $maxshowpage = 3;
            $totalpage = ceil($rowcount/$limit);
            for($i=1;$i<=$totalpage;$i++){
                //if($maxshowpage-3<=$i || $maxshowpage+3>=$i){
                if($stpage >= ($i-$maxshowpage) && $stpage <= ($i+$maxshowpage)){
                    $link = $link = cpagerparm("p")."p=".$i;$class ="";if($i==$stpage) { $class ="active";$link="#";}
        ?>
            <li class="<?php echo $class ?>"><a href="<?php echo $link ?>"><?php echo $i ?></a></li>
        <?php }} ?>
        <?php 
            $class="";if($stpage>=$totalpage) $class="disabled";
        ?>
        <li class="next <?php echo $class ?>"><a href="<?php echo cpagerparm("p") ?>p=<?php if($stpage>=$totalpage) if($totalpage<=1) echo 1 ;else echo $totalpage ; else echo $stpage+1 ; ?>">Tiếp</a></li>
    </ul>
    <div class="dataTables_info" id="example2_info">Bản ghi <b><?php echo $cpage+1 ?> đến <?php echo $cpage+$limit ?></b> / tổng số <b><?php echo $rowcount ?></b> bản ghi</div>
</div>