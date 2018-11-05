<?php
namespace App\Traits;
use App\Group;
trait Member
{
    public function test(){
        return 'hi';
    }
    public function addMember($id){

        $member = Group::create([
            'owner' => $this->id, // who is logged in
            'member' => $id,
        ]);

        if($member)
        {

            return $member;
        }

        return 'failed';

    }
}