<?php

namespace App\Http\Controllers;

use App\Events;
use App\Events\UserEvent;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Events\Dispatcher;

class CompaniesController extends Controller
{
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function getCompanies(Request $request)
    {
        $user = Auth::user();
        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        return Company::query('user_id', $user->getAuthIdentifier())
            ->take($limit)
            ->offset($offset)
            ->orderBy('id')
            ->get();
    }

    public function createCompany(Request $request)
    {
        $user = Auth::user();
        $userId = $user->getAuthIdentifier();
        $title = $request->request->get('title');
        $phone = $request->request->get('phone');
        $description = $request->request->get('description');
        $company = new Company();
        $company->user_id = $user->getAuthIdentifier();
        $company->title = $title;
        $company->phone = $phone;
        $company->description = $description;
        $company->save();

        event(new UserEvent(
            $userId,
            Events::USER_COMPANY_CREATED,
            new \DateTime()
        ));

        return [ 'id' => $company->id(),];
    }
}
