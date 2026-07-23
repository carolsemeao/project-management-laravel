<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function ShowCustomers(Request $request)
    {
        $customersQuery = Customer::query()
            ->orderBy('customers.name', 'asc')
            ->select('customers.*');
        $customers = $customersQuery->paginate(15)->appends($request->query());
        $companies = Company::all();
        return view('admin.customer.admin_customers', compact('customers', 'companies'));
    }
    
    public function ShowSingleCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $projects = $customer->projects;
        return view('admin.customer.admin_customer_single', compact('customer', 'projects'));
    }

    public function ShowCustomerUpdate($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.admin-customer-single-edit', compact('customer'));
    }
   
    public function create()
    {
        return view('admin.customer.admin_customer_create');
    }
    
    public function delete($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers')->with([
            'message' => __('Customer deleted successfully!'),
            'alert-type' => 'success'
        ]);
    }

    public function update($id)
    {

    }
}
