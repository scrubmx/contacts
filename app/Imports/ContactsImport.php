<?php

namespace App\Imports;

use App\Contact;
use App\CustomAttribute;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ContactsImport implements ToCollection, WithHeadingRow
{
    /**
     * @var array
     */
    private $headerMapping;

    /**
     * @var array
     */
    private $extraColumns;

    /**
     * ContactsImport constructor.
     *
     * @param  array  $headerMapping
     * @param  array  $extraColumns
     */
    public function __construct($headerMapping, $extraColumns = [])
    {
        $this->headerMapping = new Collection(HeadingRowFormatter::format($headerMapping));
        $this->extraColumns = new Collection(HeadingRowFormatter::format($extraColumns));
    }

    /**
     * @param \Illuminate\Support\Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $attributes = $this->headerMapping->map(fn($value, $key) => $row[$value])->all();

            /** @var \App\Contact $contact */
            $contact = Contact::create($attributes);

            if ($this->extraColumns->isNotEmpty()) {
                foreach ($this->extraColumns as $column) {
                    $contact->customAttributes()->save(new CustomAttribute(['key' => $column, 'value' => $row[$column]]));
                }
            }
        }
    }
}
