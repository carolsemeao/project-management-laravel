<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //
    public function ShowCompanies(Request $request)
    {
        $companiesQuery = Company::query()
            ->orderBy('companies.name', 'asc')
            ->select('companies.*');
        $companies = $companiesQuery->paginate(15)->appends($request->query());
        return view('admin.company.admin_companies', compact('companies'));
    }

    public function ShowSingleCompany($id)
    {
        $company = Company::findOrFail($id);
        $employees = Customer::query()
            ->where('customers.company_id', $company->id)
            ->get();
        $projects = Project::query()
            ->where('projects.company_id', $company->id)
            ->orderBy('projects.name', 'asc')
            ->get();
        return view('admin.company.admin_company_single', compact('company', 'employees', 'projects'));
    }

    public function ShowCompanyCreate()
    {
        return view('admin.company.admin_company_create');
    }

    public function ShowCompanyUpdate($id)
    {
        $company = Company::findOrFail($id);
        $employees = Customer::query()
            ->where('customers.company_id', $company->id)
            ->get();
        $projects = Project::query()
            ->where('projects.company_id', $company->id)
            ->orderBy('projects.name', 'asc')
            ->get();
        return view('admin.company.admin_company_edit', compact('company', 'employees', 'projects'));
    }
}
