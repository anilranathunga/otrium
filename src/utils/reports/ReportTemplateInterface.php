<?php

namespace src\utils\reports;

interface ReportTemplateInterface
{
    /**
     * Initiate generating report
     * @return bool|string
     */
    public function init(): bool;

    /**
     * Format and clean data fetched from database.
     * @return array
     */
    public function generateFormattedData(object $dataBaseResult): array;

    /**
     * @return mixed
     */
    public function validateParameters();
}