<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ArrayExport implements FromArray
{
    protected $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->users;
    }
}
