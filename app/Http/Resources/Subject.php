<?php

namespace App\Http\Resources;

use App\Http\Utilities\Lessons;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Subject extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $teacher =
            $this->resource['ucitel']['titulPred'] .
            ' ' . $this->resource['ucitel']['jmeno'] .
            ' ' . $this->resource['ucitel']['prijmeni'] .
            ' ' . $this->resource['ucitel']['titulZa'];

        return [
            'name' => $this->resource['nazev'],
            'shortName' => $this->resource['predmet'],
            'department' => $this->resource['katedra'],
            'teacher' => $teacher,
            'type' => $this->resource['typAkceZkr'],
            'repeat' => $this->resource['tyden'],
            'day' => mb_strtolower($this->resource['den']),
            'startsLesson' => $this->resource['hodinaOd'] ?? Lessons::getLessonByTime(Carbon::parse($this->resource['hodinaSkutOd']['value']))['order'],
            'endsLesson' => $this->resource['hodinaDo'] ?? Lessons::getLessonByTime(Carbon::parse($this->resource['hodinaSkutDo']['value']))['order'],
            'date' => $this->resource['datum']['value'],
            'dateFrom' => $this->resource['datumOd']['value'],
            'dateTo' => $this->resource['datumDo']['value'],
            'hourFrom' => $this->resource['hodinaSkutOd']['value'],
            'hourTo' => $this->resource['hodinaSkutDo']['value'],
        ];
    }
}
