<?php
/** @var array $arParams */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\ElementPropertyTable;

class CBitrixCHolidays extends CBitrixComponent
{
    public const DATE_FORMAT = 'Y-m-d';

    /**
     * Checks if the given date is a weekend or if it falls on a weekend day.
     *
     * @param DateTime $date The date to check.
     * @param array $weekends An array of weekend dates where key is the date in 'd.m.Y' format.
     * @return bool Returns true if the date is a weekend or falls on a weekend day, false otherwise.
     */
    public function isWeekend(DateTime $date, array $weekends): bool
    {
        $weekDay = (int)$date->format('N');

        // Check if the date is a weekend day or if it falls on a weekend day
        if (($weekDay === 6 || $weekDay === 7) || in_array($date->format($this::DATE_FORMAT), $weekends)) {
            return true;
        }

        return false;
    }

    /**
     * Retrieves an array of weekend days from the holiday iblock.
     *
     * @return array An array of weekend days.
     */
    public function getWeekendDays(): array
    {
        $holidays = [];

        try {
            $rsHolidays = ElementTable::getList([
                'select' => [
                    'ID',
                    'IBLOCK_ID',
                    'NAME',
                ],
                'filter' => [
                    'ACTIVE' => 'Y',
                    'IBLOCK_ID' => (int)$this->arParams['IBLOCK_ID'],
                ],
            ]);

            while ($arHoliday = $rsHolidays->Fetch()) {
                $property = ElementPropertyTable::getList([
                    'select' => ['VALUE', '*'],
                    'filter' => [
                        'IBLOCK_ELEMENT_ID' => $arHoliday['ID'],
                    ],
                ])->fetchObject();

                $holidays[$property->getValue()] = $property->getValue();
            }
        }
        catch (\Exception $e) {
            return $holidays;
        }

        return $holidays;
    }

    /**
     * This function calculates the next working day after a given date, or the current date if none is provided.
     *
     * @param int $days The number of working days to move forward.
     * @param DateTime|null $date The starting date, defaults to the current date if null.
     * @return DateTime|bool The next working day or false if days is less than 1.
     */
    public function getNextWorkingDay(int $days, DateTime $date = null): DateTime | bool
    {
        if (!$days || $days < 1) {
            return false;
        }

        $weekends = $this->getWeekendDays();
        $currentDate = $date ?? new DateTime();
        $holidayDate = null;

        while ($days > 0) {
            if (!$this->isWeekend($currentDate, $weekends)) {
                $holidayDate = clone $currentDate;
                $days--;
            }

            $currentDate->modify('+1 day');
        }

        return $holidayDate;
    }

    public function onPrepareComponentParams($arParams): array
    {
        return $arParams;
    }

    public function executeComponent(): void
    {
        $this->includeComponentTemplate();
    }
}