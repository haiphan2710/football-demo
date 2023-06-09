<?php

namespace HaiPG\LaravelCore\Common;

use App\Enums\HeadingRowCSV;

class CsvHelper
{
    protected $header;
    protected $data;
    protected $filename;
    protected $total;

    public function __construct()
    {
        //
    }

    /**
     * Logic to handle the data
     */
    public function handle()
    {
        $data = $this->arr2csv();

        return [
            'list' => $this->header . PHP_EOL . $data,
            'filename' => $this->filename,
            'count' => $this->total ?? 1,
        ];
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    protected function arr2csv()
    {
        $result = '';

        $this->data->each(function ($item) use (&$result) {
            $result .= implode(',', $item) . PHP_EOL;
        });

        return $result;
    }

    public static function checkHeader($arrayInput, $header)
    {
        $arrayHeader = [];
        if (count($arrayInput) != count($header)) {
            return $header;
        }
        foreach ($header as $value) {
            $arrayHeader [] = trim($value);
        }

        return array_diff_assoc($arrayInput, $arrayHeader);
    }

    public static function writeCSV($dataError, $fileName)
    {
        $dataError = collect($dataError);
        $header = join(',', HeadingRowCSV::CSV_SHOP_IMPORT);
        $result = '';
        $dataError->each(function ($item) use (&$result) {
            $result .= $item . PHP_EOL;
        });
        $result = $header . PHP_EOL . $result;

        return ['content' => $result, 'filename' => $fileName];
    }
}
