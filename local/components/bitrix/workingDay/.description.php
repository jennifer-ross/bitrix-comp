<?php
/** @var array $arComponentDescription */
/** @var CBitrixComponent $component */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = array(
    "NAME" => 'Следующий рабочий день',
    "DESCRIPTION" => 'Выводит следующий выходной день',
    "PATH" => array(
        "ID" => "working_day_components",
        "NAME" => 'Компоненты - Рабочие дни',
    ),
);
