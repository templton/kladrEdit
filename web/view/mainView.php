<?php
/*
 * $items - зарезервированная переменная. Содержит текущий список для отображения
 */
?>

<!DOCTYPE HTML>
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html" />
    <?php echo Application::getAssets(); ?>
    <title>Title</title>
</head>

<body>

    <div class="container">

        <div class="row">
            <h1>Главный вид</h1>
        </div>
        
        <div class="row">
            <input type="text" name="search" value="">
        </div>

        <div class="row">
            <div id="list">
            <?php
            if ($items) {
                foreach ($items as $item) {
                    ?>
                    <div class="wrapper-item">
                        <i class="glyphicon glyphicon-edit edit-item" aria-hidden="true" onclick="Controller.showEditWindow(<?php echo $item['id']; ?>)"></i>
                        <div class="head-list title closed" level="1" child="<?php echo $item['id']; ?>">
                            <i class="glyphicon glyphicon-chevron-right chevron" aria-hidden="true"></i>
                            <i class="glyphicon glyphicon-chevron-down chevron" aria-hidden="true"></i>
                            <span class="text"><?php echo $item['name']; ?></span>
                        </div>
                    </div>
                    <div class="child-list empty collapse" id='child-<?php echo $item['id']; ?>' parent="<?php echo $item['id']; ?>">
                    </div>
                    <?php
                }
            }
            ?>
            </div>
        </div>

    </div>

    <div id="editwinow" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Редактирование позиции id=<span class="item-id">XXX</span></h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="item-name" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default close-btn" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary save-btn">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>