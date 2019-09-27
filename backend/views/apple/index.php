
<button type="button" class="btn btn-primary js-gen">Сгенерировать</button>
<div class="apple">

<?php foreach($html->element as $item){
    $data = $item->getData();
    ?>
    <div class="item" data-id="<?=$data['id']?>">
        <div><?= $data['color'] ?></div>
        <div><?= $data['status'] ?></div>
        <div><?= $data['size'] ?></div>
    </div>
<?php }?>
</div>
