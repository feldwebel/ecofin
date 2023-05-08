<?php

declare(strict_types=1);

namespace App\Actions;

use App\Service;
use App\Validators\Ip4Validator;
use App\Validators\Ip6Validator;
use App\Validators\IValidator;
use App\Validators\SensorNameValidator;
use App\Validators\UuidValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AverageSensorAction
{
    private IValidator $validators;
    private Service $service;

    public function __construct()
    {
        $this->validators = new SensorNameValidator([
            new Ip4Validator(),
            new Ip6Validator(),
            new UuidValidator(),
        ]);

        $this->service = new Service();
    }

    public function __invoke(array $query): Response
    {
        $ip = $query['ip'] ?? '';

        if (!$this->validators->validate($ip)) {
            throw new \RuntimeException($this->validators->getError());
        }

        if (!$this->service->findSensorByName($ip)) {
            throw new \RuntimeException("No sensor $ip found");
        }

        $average = $this->service->averageBySensor($ip);

        return new JsonResponse(['value' => $average, 'sensor' => $ip]);
    }
}
