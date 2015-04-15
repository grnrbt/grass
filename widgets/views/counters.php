<?php
/* @var \yii\web\View $this */
/* @var string $placement top|bottom */

if($placement == 'top'){
?>
    <script>
        console.log(1);
    </script>
<?php
} else {
?>
    <script>
        console.log(2);
    </script>
<?php
}