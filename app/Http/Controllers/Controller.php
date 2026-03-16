<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Zytrixon Mobile API Documentation",
    description: "API documentation for the Zytrixon Truck Billing mobile application.",
    contact: new OA\Contact(email: "admin@zytrixon.com")
)]
#[OA\Server(
    url: "http://127.0.0.1:8000",
    description: "Local Development Server"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT",
    description: "Enter your Sanctum token here"
)]
abstract class Controller
{
    //
}
