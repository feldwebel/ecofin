<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Response;

class CsvResponse extends Response
{

    public function __construct(mixed $data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct('', $status, $headers);

        $this->setCSV($data);
    }

    public function setCSV(string $csv): static
    {
        $this->setContent($csv);

        return $this->update();
    }

    protected function update(): static
    {
        $this->headers->set('Content-Type', 'text/csv');
        return $this;
    }
}
