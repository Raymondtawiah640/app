<?php

namespace App\Imports;

use App\Models\School;

class SchoolsImport extends \Maatwebsite\Excel\Files\ExcelFile
{
    public function getFile()
    {
        return $this->file;
    }

    public function import()
    {
        $reader = \Excel::load($this->file->getRealPath());

        $results = $reader->get();

        foreach ($results as $row) {
            School::create([
                'name' => $row->name ?? '',
                'location' => $row->location ?? '',
                'contact' => $row->contact ?? '',
                'status' => $row->status ?? '',
                'website' => $row->website ?? '',
            ]);
        }

        return $results->count();
    }
}