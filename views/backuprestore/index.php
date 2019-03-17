<div class="backup-default-index">

    <?php
    $this->params ['breadcrumbs'] [] = [
        'label' => 'Manage',
        'url' => array(
            'index'
        )
    ];
    ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <?php
            echo $this->render('_list', array(
                'dataProvider' => $dataProvider
            ));
            ?>
        </div>
    </div>

</div>