<?php
/** @var array $arComponentParameters */
/** @var CBitrixComponent $component */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

CModule::IncludeModule('iblock');

use \Bitrix\Iblock\IblockTable;

$blockIDs = [];
$blockTypes = IblockTable::getList();

while ($arBlockType = $blockTypes->Fetch()) {
    $blockIDs[$arBlockType['ID']] = '[' . $arBlockType['ID'] . '] ' .$arBlockType['NAME'];
}

$arComponentParameters = [
    'GROUPS' => [],
    'PARAMETERS' => [
        'IBLOCK_ID' => array(
            'NAME' => 'Инфоблок',
            'TYPE' => 'LIST',
            'VALUES' => $blockIDs,
            'REFRESH' => 'Y',
            'ADDITIONAL_VALUES' => 'N',
        ),
    ]
];