<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use phpDocumentor\Reflection\Types\Boolean;

// This is to prevent the import to have slugs for the columns
// HeadingRowFormatter::default('none');

class ImportExcelToArray implements ToArray, WithHeadingRow, WithEvents, WithCalculatedFormulas
{
    public $sheetNames;
    public $sheetData;
    public $startingRow;

    public function __construct(){
        $this->sheetNames = [];
        $this->sheetData = [];
        $this->startingRow = 1;
    }
    public function array(array $array)
    {
        $this->sheetData[$this->sheetNames[count($this->sheetNames)-1]] = $array;
    }
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->sheetNames[] = $event->getSheet()->getTitle();
            } 
        ];
    }
    public function chunkSize(): int
    {
        return 5;
    }
    public function headingRow(): int
    {
        return $this->startingRow;
    }
    public function getHeaders($sheetName): array
    {
        //By giving the sheet name, it will return an array with all the column names that are in this sheet
        if (!empty($this->sheetData[$sheetName][0])) {
            $headers = [];
            foreach ($this->sheetData[$sheetName][0] as $rowHeader => $rowValue) {
                array_push($headers,$rowHeader);
            }
            return $headers;
        } else {
            return [];
        }
    }
    public function checkMinHeaders($sheetName, $minColumns)
    {
        // This function fill check on the sheet name provided if it has at least the columns from $minColumns
        $headers = $this->getHeaders($sheetName);
        $minimumRequired = !array_diff($minColumns, $headers);
        return $minimumRequired;
    }
}
