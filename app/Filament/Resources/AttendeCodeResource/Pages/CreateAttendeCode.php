<?php

namespace App\Filament\Resources\AttendeCodeResource\Pages;

use App\Filament\Resources\AttendeCodeResource;
use DateInterval;
use DatePeriod;
use DateTime;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAttendeCode extends CreateRecord
{
    protected static string $resource = AttendeCodeResource::class;

    protected $isCreateBulk = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!$data['bulk_create']) {
            return $data;
        }

        $this->isCreateBulk = true;

        $start_date = new DateTime($data['range_date'][0]);
        $end_date = (new DateTime($data['range_date'][1]))->setTime(0, 0, 1);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start_date, $interval, $end_date);

        foreach ($period as $date) {
            $fullData[] = [
                'id' => str()->uuid(),
                'user_id' => $data['user_id'],
                'default_approval_status_id' => $data['default_approval_status_id'],
                'attende_type_id' => $data['attende_type_id'],
                'start_date' => $date->format('Y-m-d') . ' ' . $data['start_time'],
                'end_date' => $date->format('Y-m-d') . ' ' . $data['end_time'],
                'description' => $data['description'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'radius' => $data['radius'],
                'created_at' => now(),
            ];
        }

        return $fullData;
    }

    protected function handleRecordCreation(array $data): Model
    {
        if ($this->isCreateBulk) {
            $this->isCreateBulk = false;
            static::getModel()::insert($data);

            return static::getModel()::first();
        }
        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
