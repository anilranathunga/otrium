<?php

namespace src\reportTemplates;

use src\models\Gmv;
use src\utils\HttpRequest;
use src\utils\reports\BaseReport;
use src\utils\reports\ReportTemplateInterface;
use src\utils\reports\Row;

class DailyTurnOverReport extends BaseReport implements  ReportTemplateInterface
{
    private string $startDate;
    private string $endDate;

    /**
     * DailyTurnOverReport constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters,object $reportSpecificConfigs)
    {
        $this->startDate = $parameters['startDate'];
        $this->endDate = $parameters['endDate'];
        $this->reportSpecificConfigs = $reportSpecificConfigs;
    }

    /**
     * @return string|bool
     */
    function init(): bool
    {
        if (!$this->validateParameters())
            return false;

        $gmv = new Gmv();
        $dbRecords = $gmv->getTotalTurnOverDaily($this->startDate, $this->endDate);

        if ($dbRecords->num_rows==0){
            return false;
        }

        $filesRows = $this->generateFormattedData($dbRecords);
        $this->fileName = "Daily_TurnOver_Exc_Tax_{$this->startDate}_{$this->endDate}.csv";

        return $this->generateFile($filesRows,$this->fileName);
    }


    /**
     * @param $DbRecords
     * @return array
     */
    public function generateFormattedData(object $DbRecords): array
    {
        $rows = [];
        foreach ($DbRecords as $record){
            $rows[] = New Row($record);
        }

        $fileRows[] = $rows[0]->getHeaders();

        foreach($rows as $row){
            $row->removeTaxOnlyIn(["Total_TO"]);
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