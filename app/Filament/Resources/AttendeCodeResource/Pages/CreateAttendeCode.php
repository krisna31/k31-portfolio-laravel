<?php

namespace App\Filament\Resources\AttendeCodeResource\Pages;

use App\Filament\Resources\AttendeCodeResource;
use App\Models\Attende;
use App\Models\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateAttendeCode extends CreateRecord
{
    protected static string $resource = AttendeCodeResource::class;

    protected $isCreateBulk = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['location'] != null) {
            $loc = explode('#', $data['location']);
            $data['latitude'] = $loc[0];
            $data['longitude'] = $loc[1];
        }

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
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'radius' => $data['radius'] ?? null,
                'created_at' => now(),
            ];
        }

        return $fullData;
    }

    protected function handleRecordCreation(array $data): Model
    {
        DB::beginTransaction();

        try {
            if ($this->isCreateBulk) {
                $this->isCreateBulk = false;
                static::getModel()::insert($data);

                foreach ($data as $item) {
                    if ($item['user_id'] == 0) {
                        $users = User::where('id', '!=', 0)->get();
                        foreach ($users as $user) {
                            Attende::create([
                                'user_id' => $user->id,
                                'attende_code_id' => $item['id'],
                                'approval_status_id' => null,
                                'attende_status_id' => null,
                                'attende_time' => null,
                                'address' => null,
                                'photo' => null,
                                'latitude' => null,
                                'longitude' => null,
                            ]);
                        }
                    } else {
                        Attende::create([
                            'user_id' => $item['user_id'],
                            'attende_code_id' => $item['id'],
                            'approval_status_id' => null,
                            'attende_status_id' => null,
                            'attende_time' => null,
                            'address' => null,
                            'photo' => null,
                            'latitude' => null,
                            'longitude' => null,
                        ]);
                    }
                }

                DB::commit();
                return static::getModel()::first();
            }

            $insertedData = static::getModel()::create($data);

            if ($insertedData['user_id'] == 0) {
                $users = User::where('id', '!=', 0)->get();
                foreach ($users as $user) {
                    Attende::create([
                        'user_id' => $user->id,
                        'attende_code_id' => $insertedData['id'],
                        'approval_status_id' => null,
                        'attende_status_id' => null,
                        'attende_time' => null,
                        'address' => null,
                        'photo' => null,
                        'latitude' => null,
                        'longitude' => null,
                    ]);
                }
            } else {
                Attende::create([
                    'user_id' => $insertedData['user_id'],
                    'attende_code_id' => $insertedData['id'],
                    'approval_status_id' => null,
                    'attende_status_id' => null,
                    'attende_time' => null,
                    'address' => null,
                    'photo' => null,
                    'latitude' => null,
                    'longitude' => null,
                ]);
            }

            DB::commit();
            return $insertedData;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
