<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sP = ($this->share->balance / 15000) * 100;
        if ($sP > 100) {
            $sP = 100;
        }
        $lP = ($this->loan->balance / $this->loan->amount) *100;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'phone2' => $this->phone2,
            'email' => $this->email,
            'member_id' => $this->member_id,
            'address' => $this->address,
            'sex' => $this->sex,
            'marital' => $this->marital,
            'profession' => $this->profession,
            'purpose' => $this->purpose,
            'referrer' => $this->referrer,
            'nok' => $this->nok,
            'nok_address' => $this->nok_address,
            'nok_phone' => $this->nok_phone,
            'nok_phone2' => $this->nok_phone2,
            'pix' => $this->pix,
            'sharePercent' => $sP,
            'loanPercent' => $lP,
            'savingH' => $this->savings->history,
            'loanH' => $this->loan->repayments,
            'loan' => $this->getLoan(),
            'saving' => $this->getSaving(),
            'share' => $this->getShare(),
            'building' => $this->getBuilding(),
        ];
    }
}
