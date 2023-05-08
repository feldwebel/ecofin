<?php

declare(strict_types=1);

namespace App\Actions;

use App\CsvResponse;
use App\Service;
use App\Validators\Ip4Validator;
use App\Validators\Ip6Validator;
use App\Validators\IValidator;
use App\Validators\SensorNameValidator;
use Symfony\Component\HttpFoundation\Response;

class SensorReadAction
{
    private IValidator $validators;
    private Service $service;

    public function __construct()
    {
        $this->validators = new SensorNameValidator([
            new Ip4Validator(),
            new Ip6Validator(),
        ]);

        $this->service = new Service();
    }

    public function __invoke(array $query): Response
    {
        $ip = $query['ip'] ?? '';

        if (!$this->validators->validate($ip)) {
            throw new \RuntimeException($this->validators->getError());
        }
        $value = random_int(-1000, 8000)/100;
        $sensor = $this->service->findSensorByName($ip);

        if ($sensor) {
            $reading = $this->service->addReadingBySensor($sensor['id'], $value);
        } else {
            $reading = $this->service->addSensorAndReading($ip, $value);
        }

        return new Response("$reading,$value");
        //return new CsvResponse("$reading,$value");
    }
}
