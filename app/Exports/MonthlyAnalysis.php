<?php

namespace App\Exports;

use App\Member;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonthlyAnalysis implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    private $start;
    private $end;
    private $type;
    private $sn;
    public function __construct($start, $end, $type)
    {
        $this->start = $start;
        $this->end = $end;
        $this->type = $type;
    }

    public function headings(): array
    {
        return ['S/N', 'ID', 'NAME', 'ATTENDANCE', 'SHARES', 'SAVINGS', 'SPECIAL SAVINGS', 'LOAN REPAYMENT'
            , 'LOAN INTEREST', 'UTILITIES', 'FINE', 'BUILDING', 'TOTAL'
        ];
    }

    /**
     * @var Member $member
     */
    public function map($member): array
    {
        if ($member->savings) {
            $savingsC = $member->savings->history->whereBetween('created_at', [$this->start, $this->end])->sum('credit');
            $savingsD = $member->savings->history->whereBetween('created_at', [$this->start, $this->end])->sum('debit');
        } else {
            $savingsD = 0;
            $savingsC = 0;
        }
        if ($member->share) {
            $shareC = $member->share->history->whereBetween('created_at', [$this->start, $this->end])->sum('credit');
            $shareD = $member->share->history->whereBetween('created_at', [$this->start, $this->end])->sum('debit');
        } else {
            $shareD = 0;
            $shareC = 0;
        }
        if ($member->specialSavings) {
            $specialC = $member->specialSavings->history->whereBetween('created_at', [$this->start, $this->end])->sum('credit');
            $specialD = $member->specialSavings->history->whereBetween('created_at', [$this->start, $this->end])->sum('debit');
        } else {
            $specialD = 0;
            $specialC = 0;
        }
        if ($member->building) {
            $buildingC = $member->building->history->whereBetween('created_at', [$this->start, $this->end])->sum('credit');
            $buildingD = $member->building->history->whereBetween('created_at', [$this->start, $this->end])->sum('debit');
        } else {
            $buildingD = 0;
            $buildingC = 0;
        }
        if ($member->loans) {
            $cre = 0;
            $int = 0;
            foreach($member->loans->whereBetween('updated_at', [$this->start, $this->end]) as $item) {
                $cre = $cre + $item->repayments->whereBetween('created_at', [$this->start, $this->end])->sum('credit');
                $int = $int + $item->repayments->whereBetween('created_at', [$this->start, $this->end])->sum('interest');
            }
        } else {
            $cre = 0;
            $int = 0;
        }
        if(isset($this->sn)) {
          $this->sn = $this->sn + 1;
        } else {
          $this->sn = 1;
        }
        $sq = $this->sn + 1;
        return [
            $this->sn,
            $member->member_id,
            $member->name,
            1,
            $shareC - $shareD,
            $savingsC - $savingsD,
            $specialC - $specialD,
            $cre,
            $int,
            0,
            0,
            $buildingC - $buildingD,
            "=SUM(E$sq:K$sq)"
        ];
    }

    public function collection()
    {
        return Member::all();
    }
}
