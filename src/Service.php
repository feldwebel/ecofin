<?php

declare(strict_types=1);

namespace App;

class Service
{
    protected \PDO $link;

    public function __construct()
    {
        $this->link = DB::me()->getLink();
    }

    public function findSensorByName(string $name): bool|array
    {
        $query = $this->link->prepare('select * from sensors where "name" = :name');

        $query->execute(['name' => $name]);

        return $query->fetch();
    }

    public function addReadingBySensor(int $sensorId, float $value): bool|string
    {
        $query = $this->link->prepare('insert into sensor_readings (sensor_id, value) values (:sensorId, :value)');
        $query->execute([
            'sensorId' => $sensorId,
            'value' => $value,
        ]);

        return $this->link->lastInsertId();
    }

    public function addSensor(string $name): bool|string
    {
        $query = $this->link->prepare('insert into sensors ("name") values (:name) on conflict do nothing');
        $query->execute(['name' => $name]);

        return $this->link->lastInsertId();
    }

    public function addSensorAndReading(string $name, float $value): bool|string
    {
        $this->link->beginTransaction();
        $sensorId = $this->addSensor($name);
        if (!$sensorId) {
            $this->link->rollBack();
            throw new \RuntimeException("Cannot add sensor $name");
        }
        $readingId = $this->addReadingBySensor((int)$sensorId, $value);
        if (!$readingId) {
            $this->link->rollBack();
            throw new \RuntimeException("Cannot add reading for sensor $name");
        }
        $this->link->commit();

        return $readingId;
    }

    public function averageBySensor(string $name): float
    {
        $sql = 'select avg(value) from sensor_readings sr left join sensors s on sr.sensor_id = s.id where s.name=:name';
        $query = $this->link->prepare($sql);
        $query->execute(['name' => $name]);

        return (float)$query->fetchColumn();
    }

    public function averageByDays(int $day): float
    {
        $sql = "select avg(value) from sensor_readings sr where created_at > current_timestamp::date - :day * '1 day'::interval";
        $query = $this->link->prepare($sql);
        $query->execute(['day' => $day]);

        return (float)$query->fetchColumn();
    }
}
