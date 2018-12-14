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

    /**
     * Status user
     *
     * Status the specified user in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function updateAgreement(Request $request)
    {
        // $this->authorize($user);

        
        // Update user role only for admin
        // if ($request->get('role') && $request->get('role') !== $user->role) {
        //     if (auth()->user()->isSeller()) abort(401, 'Usted no esta autorizado ha modificar el estado de un vendedor');

            $user= Contract::where('hired', $request->id)->first();
            $user->agreement = $request->agreement;
            $user->update();
        // }

    return ['user' => $user];
    }

}
