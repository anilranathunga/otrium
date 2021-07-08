<?php

namespace src\configs;

class Config
{
    //deployment related configs
    const APP_URL = "http://localhost:8888/";     // remove trailing slash

    const DB_HOST = "localhost";
    const DB_PORT = 8889;
    const DB_NAME = "otrium";
    const DB_USER = "root";
    const DB_PASSWORD = "root";

    //business logic configs
    const TAX_RATE = 21;

    //application configs
    const TEMPLATES_PATH = "src/templates";
    const FILE_LOCATION = "generatedReports/";          //with trailing slash
    const DATE_FORMAT = "Y-m-d";
}