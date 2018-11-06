<?php

namespace App\Http\Controllers;

use App\Contract;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\Contracts as ContractsResource;
use App\Http\Resources\ContractsCollection;


class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getContracts(Request $request)
    {
        $hired_list = Contract::with('hired')->where('contractor', $request->user()->id)->get();

        $contractor = User::with('contractor')->where('id', $request->user()->id)->get();


        return ['contracts' => $hired_list, 'contractor' => $contractor];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getContractor(Request $request)
    {
        $list = Contract::with('contractor')->where('hired', $request->user()->id)->first();


        return ['contractor' => $list];
    }

}
