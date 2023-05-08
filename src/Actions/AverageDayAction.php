<?php

declare(strict_types=1);

namespace App\Actions;

use App\Service;
use Symfony\Component\HttpFoundation\JsonResponse;

class AverageDayAction
{
    private Service $service;

    public function __construct()
    {
        $this->service = new Service();
    }

    public function __invoke(array $query): JsonResponse
    {
        $day = (int)$query['day'];
        $average = $this->service->averageByDays($day);

        return new JsonResponse(['value' => $average, 'days' => $day]);
    }
}
