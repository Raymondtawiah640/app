<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return view('schools', compact('schools'));
    }

    public function uploadSchools(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:csv|max:2048',
        ]);

        try {
            $file = $request->file('excel_file');
            $data = $this->parseCSV($file);

            foreach ($data as $row) {
                School::create([
                    'name' => $row['name'] ?? '',
                    'location' => $row['location'] ?? '',
                    'contact' => $row['contact'] ?? '',
                    'status' => $row['status'] ?? '',
                    'website' => $row['website'] ?? '',
                ]);
            }

            return redirect()->back()->with('success', count($data) . ' schools imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing schools: ' . $e->getMessage());
        }
    }

    private function parseCSV($file)
    {
        $data = [];
        $handle = fopen($file->getRealPath(), 'r');

        // Read header row
        $header = fgetcsv($handle);
        if (!$header) {
            throw new \Exception('CSV file must have a header row');
        }

        // Convert headers to lowercase for case-insensitive matching
        $header = array_map('strtolower', $header);

        // Check required columns
        $required = ['name', 'location', 'contact', 'status', 'website'];
        foreach ($required as $field) {
            if (!in_array($field, $header)) {
                throw new \Exception("Required column '$field' not found in CSV header");
            }
        }

        // Read data rows
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) === count($header)) {
                $data[] = array_combine($header, $row);
            }
        }

        fclose($handle);
        return $data;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'website' => 'required|url',
        ]);

        School::create($request->all());

        return redirect()->back()->with('success', 'School added successfully!');
    }
}
