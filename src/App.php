<?php

namespace src;

use src\configs\Config;
use src\utils\HttpRequest;
use src\utils\Session;

class App
{
    /**
     * Initiate reporting tool
     * and generate report according to route
     */
    protected string $basePath;
    protected static string $route;
    protected object $httpRequest;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
        $this->httpRequest = new HttpRequest();
    }

    public function init():void
    {
        try {
            $route = $this->resolveRoute();

            if ($_SERVER['REQUEST_METHOD'] == "POST" && (array_key_exists("report_type", $_POST))) {

                $rules = ["report_type" => ["Report Type",["string"]]];

                if ($this->httpRequest->validate($rules) === true){
                    $this->generateReport();
                }else{
                    $this->redirectBack();
                }
            }
            $this->loadTemplate($route);

        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function resolveRoute(): string
    {
        $fulUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $route = str_replace(Config::APP_URL,"",$fulUrl);

        if ($route=="/index.php"){
            $route = "/";
        }

        include ("routes.php");

        if (array_key_exists($route,$routes)){
            self::$route = $route;
            return $route;
        }else{
            throw new \Exception("Route not found : $route");
        }
    }

    private function generateReport(): bool
    {
        try {
            if (array_key_exists("report_type",$_POST) && ($_POST["report_type"] == "null")) {
                Session::setFlash('error','Select a report type');
                return false;
            }

            $json = file_get_contents($this->basePath . "/src/configs/reportsConfigs.json");
            $jsonObjsArray = json_decode($json);
            $parameters = $this->httpRequest->getParameters();
            $reportTemplateClass = null;
            $reportSpecificConfigs = [];
            foreach ($jsonObjsArray as $key => $obj) {
                if (array_key_exists("report_type", $_POST)) {
                    if ($key == $_POST["report_type"]) {
                        $reportTemplateClass = 'src\reportTemplates\\' . $obj->class;
                        $reportSpecificConfigs = $obj->configs;
                        break;
                    }
                }
            }

            if (class_exists($reportTemplateClass)) {
                $report = new $reportTemplateClass($parameters,$reportSpecificConfigs);
                $status = $report->init();
                if ($status){
                    $report->downloadFile();
                    $report->deleteFile();
                    return true;
                }
            }
            return false;
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

    /**
     * @param $report
     * generate file and delete after download
     */
    function downloadAndDeleteFile($report): void
    {
        $report->downloadFile();
        $report->deleteFile();
    }

    /**
     * load template file according to route. template mapping is in route.php file
     * @param $path
     */
    function loadTemplate($route):void
    {
        include ("routes.php");

        $template = $routes[$route];

        include Config::TEMPLATES_PATH.'/header.php';
        include Config::TEMPLATES_PATH.'/'.$template.'.php';
        include Config::TEMPLATES_PATH.'/footer.php';
    }

    public static function redirectBack()
    {
        header("location:".Config::APP_URL.self::$route);
    }
}