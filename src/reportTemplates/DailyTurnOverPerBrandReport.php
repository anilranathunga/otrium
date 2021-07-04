<?php

namespace src\reportTemplates;

use src\App;
use src\models\Brand;
use src\utils\HttpRequest;
use src\utils\reports\BaseReport;
use src\models\Gmv;
use src\utils\reports\ReportTemplateInterface;
use src\utils\reports\Row;
use src\utils\Validator;

class DailyTurnOverPerBrandReport extends BaseReport implements ReportTemplateInterface
{
    private string $startDate;
    private string $endDate;

    /**
     * DailyTurnOverPerBrandReport constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters, object $reportSpecificConfigs)
    {
        $this->startDate = $parameters['startDate'];
        $this->endDate = $parameters['endDate'];
        $this->reportSpecificConfigs = $reportSpecificConfigs;
    }

    /**
     * @return bool|string
     */
    function init(): bool
    {
        if (!$this->validateParameters())
            return false;

        $gmv = new Gmv();
        $dataBaseRecordsForReport = $gmv->getTotalTurnOverPerBrandDaily($this->startDate, $this->endDate);

        if ($dataBaseRecordsForReport->num_rows==0){
            return false;
        }

        $filesRows = $this->generateFormattedData($dataBaseRecordsForReport);
        $this->fileName = "Daily_TurnOver_By_Brand_Exc_Tax_{$this->startDate}_{$this->endDate}.csv";

        return $this->generateFile($filesRows, $this->fileName);
    }

    /**
     * @param $data
     * @return array
     */
    function generateFormattedData(object $bdRecords): array
    {
        $rows = [];
        foreach ($bdRecords as $record) {
            $rows[] = new Row($record);
        }

        $fileRows[] = $rows[0]->getHeaders();

        foreach ($rows as $row) {
            $row->removeTaxExcept(["Date"]);
            $fileRows[] = $row->getData();
        }

        return $fileRows;
    }

    public function validateParameters(): bool
    {
        $httpRequest = new HttpRequest();

        $rules = [
            "startDate" => ["Start Date",["date"]],
            "endDate" => ["End Date",["date","dateGreaterThan:startDate"]],
        ];
        return $httpRequest->validate($rules) === true;
    }
}