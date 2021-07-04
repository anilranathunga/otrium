<?php

namespace src\utils\reports;

use src\configs\Config;

class BaseReport
{
    public array $data;
    protected object $reportSpecificConfigs;
    protected string $fileName;
    /**
     * Report constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     * @param string $filename
     * Generate CSV file
     */
    function generateFile(array $data, string $filename): bool
    {
        try {

            $filePath = Config::FILE_LOCATION.$filename;

            if (!file_exists($filePath)){

                $file = fopen($filePath, 'x');
                chmod($filePath, 0777);
                foreach ($data as $row)
                {
                    fputcsv($file, $row, $this->reportSpecificConfigs->delimiter);
                }

                fclose($file);

            }

            return true;
        }catch (\Exception $exception){

            echo "Error on creating file: ".$exception->getMessage();
            return false;
        }
    }


    /**
     * @param $fileName
     */
    public function downloadFile($fileName = null): void
    {
        try {
            $fileNameToDownload = $fileName ?: $this->fileName;
            $filePath = Config::FILE_LOCATION.$fileNameToDownload;
            ob_end_clean();
            header("Content-type:text/csv");
            header('Content-Disposition: attachment; filename=' . $fileNameToDownload);
            readfile( $filePath );
            exit();
        }catch (\Exception $exception){
            echo "Error on downloading file" . $exception->getMessage();
        }

    }


    /**
     * @param $fileName
     * @return bool|string
     */
    public function deleteFile($fileName = null): bool|string
    {
        $fileNameToDelete = $fileName ?: $this->fileName;
        try {
            return unlink(Config::FILE_LOCATION.$fileNameToDelete);
        }catch (\Exception $exception){
            echo "File delete error ".$exception->getMessage();
        }
    }
}