<?php
namespace app\components;
use yii\base\Component;
use Yii;

class MetaComponent extends Component{

    public $keywords = 'โปรแกรมหอพัก,โปรแกรมบริหารหอพัก,ระบบหอพัก,ระบบอพาร์ทเม้นต์รายเดือน,ระบบ wifi หอพัก,wifi hotspot,wifi หอพัก';
    public $description = 'จำหน่ายโปรแกรมหอพัก พาร์ทเม้นต์ รายวัน รายเดือน';

    public $image = '';

    public function displaySeo(){

        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $this->description,
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $this->keywords,
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:description',
            'content' => $this->description,
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:image',
            'content' => $this->image,
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:description',
            'content' => $this->description,
        ]);

        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:image',
            'content' => $this->image,
        ]);

    }
}