<?php

namespace App\Models;

use App\Enums\AgeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Patient extends Model
{
    // 300 секунд = 5 минут
    const CACHE_TIME_TO_LIVE = 300;
    const CACHE_ALL_KEY = 'all_patients';
    const CACHE_SINGLE_KEY_PREFIX = 'patient_';

    public $timestamps = false;


    protected $table = null;

    protected $fillable = [
        'first_name', 'last_name', 'birthdate', 'age', 'age_type'
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->calculateAge();
    }

    /**
     * Вычисление возраста и типа возраста
     *
     * @return void
     */
    public function calculateAge(): void
    {
        $birthdate = Carbon::parse($this->birthdate);
        $now = Carbon::now();

        if ($birthdate->diffInMonths($now) < 1) {
            $age = $birthdate->diffInDays($now);
            $this->age_type = AgeType::Day;
        } elseif ($birthdate->diffInYears($now) < 1) {
            $age = $birthdate->diffInMonths($now);
            $this->age_type = AgeType::Month;
        } else {
            $age = $birthdate->diffInYears($now);
            $this->age_type = AgeType::Year;
        }

        $this->age = (int)floor($age);
    }

    public function getAgeTypeText(): string
    {
        return match($this->age_type) {
            AgeType::Day   => 'день',
            AgeType::Month => 'месяц',
            AgeType::Year  => 'год',
        };
    }

    public function getAgeText(): string
    {
        return $this->age . ' ' . $this->getAgeTypeText();
    }

    public function getName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getBirthdateText(): string
    {
        return $this->birthdate->format('d.m.Y');
    }

    public function cache(): void
    {
        $patientId = Str::uuid()->toString();
        $this->id = $patientId;

        // Сохраняем объект в кэше
        $cacheKey = self::CACHE_SINGLE_KEY_PREFIX . $patientId;
        Cache::put($cacheKey, $this, self::CACHE_TIME_TO_LIVE);

        // Добавляем идентификатор в список всех пациентов
        $allPatients = Cache::get(self::CACHE_ALL_KEY, []);
        $allPatients[] = $cacheKey;
        Cache::put(self::CACHE_ALL_KEY, $allPatients, self::CACHE_TIME_TO_LIVE);
    }
}
