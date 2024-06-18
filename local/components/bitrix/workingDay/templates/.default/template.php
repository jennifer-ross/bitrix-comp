<?php
/** @var CBitrixComponentTemplate $this */
/** @var CBitrixCHolidays $component */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);

if (!empty($_POST) && isset($_POST['days'])) {
    $component = $this->getComponent();
    $days = intval(htmlspecialchars($_POST['days'], ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"));

    $date = $component->getNextWorkingDay($days);
    if ($date !== false) {
        ?>
            <p>Дата рабочего дня: <span><?= $date->format('d.m.Y') ?></span></p>
        <?php
    } else {
        ?>
            <p class="error">Вы ввели некорректное количество дней</p>
        <?php
    }
}
?>
<div class="form-wrapper">
    <form method="post" class="form">
        <?=bitrix_sessid_post()?>
        <div class="form-group">
            <label for="days">Количество дней</label><input min="1" max="365" type="number" name="days" required id="days">
        </div>
        <button type="submit">Рассчитать</button>
    </form>
</div>