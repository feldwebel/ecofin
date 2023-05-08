<?php

declare(strict_types=1);

namespace App\Actions;

use App\Service;
use App\Validators\IValidator;
use App\Validators\UuidValidator;
use Symfony\Component\HttpFoundation\Response;

class ApiPushAction
{
    private IValidator $validators;
    private Service $service;

    public function __construct()
    {
        $this->validators = new UuidValidator();

        $this->service = new Service();
    }

    public function __invoke(): Response
    {
        $body = file_get_contents('php://input');
        $parsed = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        if (!array_key_exists('reading', $parsed) || !isset($parsed['reading']['sensor_uuid'], $parsed['reading']['temperature'])) {
            throw new \RuntimeException("Malformed request body");
        }
        if (!$this->validators->validate($parsed['reading']['sensor_uuid'])) {
            throw new \RuntimeException($this->validators->getError());
        }

        $uuid = $parsed['reading']['sensor_uuid'];
        $value = (float)$parsed['reading']['temperature'];
        $sensor = $this->service->findSensorByName($uuid);

        if ($sensor) {
            $reading = $this->service->addReadingBySensor($sensor['id'], $value);
        } else {
            $reading = $this->service->addSensorAndReading($uuid, $value);
        }

        return new Response();
    }
}
