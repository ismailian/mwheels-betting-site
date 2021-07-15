<div class="col-lg-8 col-md-8">
   <div class="single-feature landscape justify-content-center">
      <div class="content">
         <h4 class="title mb-5">
            Winning Numbers
         </h4>
         <hr>
         <span id="winnum"><?= !is_null((Winner::number("x1")->number)) ? ("0" . Winner::number("x1")->number) : "N/A"; ?></span>
         <span id="winnum"><?= !is_null((Winner::number("x2")->number)) ? ("0" . Winner::number("x2")->number) : "N/A"; ?></span>
         <span id="winnum"><?= !is_null((Winner::number("x3")->number)) ? ("0" . Winner::number("x3")->number) : "N/A"; ?></span>
         <span id="winnum"><?= !is_null((Winner::number("x4")->number)) ? ("0" . Winner::number("x4")->number) : "N/A"; ?></span>
         <span id="winnum"><?= !is_null((Winner::number("x5")->number)) ? ("0" . Winner::number("x5")->number) : "N/A"; ?></span>
         <span id="winnum"><?= !is_null((Winner::number("x6")->number)) ? ("0" . Winner::number("x6")->number) : "N/A"; ?></span>
         <span id="winnum"><?= !is_null((Winner::number("x7")->number)) ? ("0" . Winner::number("x7")->number) : "N/A"; ?></span>
         <hr>
         <h4 class="title mt-5">
            <?= (date("d M, Y")); ?>
         </h4>
      </div>
   </div>
</div>