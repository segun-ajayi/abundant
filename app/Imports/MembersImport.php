<?php

namespace App\Imports;

use App\Member;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MembersImport implements ToCollection, WithChunkReading, ShouldQueue
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row)
        {
            $member = Member::create([
                'member_id' => $row[1],
                'name' => $row[2],
                'address' => $row[3],
                'sex' => $row[4],
                'marital' => $row[5],
                'phone' => $row[6],
                'phone2' => $row[7],
                'email' => $row[8],
                'profession' => $row[9],
                'purpose' => $row[10],
                'referrer' => $row[11],
                'nok' => $row[12],
                'nok_address' => $row[13],
                'nok_phone' => $row[14],
                'nok_phone2' => $row[15],
                'pix' => $row[1] . '.png',
            ]);
            if($row[16]) {
                $member->creditShare($row[16], 'import');
            }
            if($row[17]) {
                $member->creditSavings($row[17], 'import');
            }
            if ($row[19]) {
                $member->loans()->create(['balance' => $row[19],
                    'amount' => $row[19],
                    'lpDate' => Carbon::parse('2019-12-31 14:39:11')->format('Y-m-d H:i:s')
                ]);
            }
            if ($row[20]) {
                $member->creditSpecial($row[20], 'import');
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
