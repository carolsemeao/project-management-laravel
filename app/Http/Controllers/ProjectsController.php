<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectStatus;
use App\Models\ProjectPriority;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Offer;

class ProjectsController extends Controller
{
    public function ShowProjects()
    {
        $user = Auth::user();
        $userProjects = $user->projects()->pluck('projects.id');
        $projects = Project::whereIn('id', $userProjects)->get();
        return view('admin.project.admin_projects', compact('projects'));
    }

    public function ShowSingleProject($id)
    {
        $project = Project::findOrFail($id);
        $user = Auth::user();
        $totalIssues = $project->issues()->count();
        $openIssues = $project->getOpenIssuesCount();
        $issuesInProgress = $project->getIssuesByStatus(3);
        $totalLoggedTime = $project->getTotalLoggedTimeMinutes();
        $timeProgress = $project->getCombinedTimeProgress();
        $offers = Offer::where('project_id', $id)->get();
        $recentOffer = Offer::where('project_id', $id)->orderBy('created_at', 'desc')->limit(1)->get();
        
        // Check if user is assigned to this project (directly or through teams)
        if (!$user->isAssignedToProject($id)) {
            abort(403, 'You do not have permission to view this project.');
        }
        
        // Generate charts for the analytics tab (like dashboard approach)
        $chartController = app(ChartController::class);
        
        try {
            $projectCharts = $chartController->getProjectCharts($id);
            $projectIssueStatusChart = $projectCharts['issueStatusChart'];
            $projectIssuePriorityChart = $projectCharts['issuePriorityChart'];            
        } catch (\Exception $e) {
            // Fallback to empty values
            $projectIssueStatusChart = null;
            $projectIssuePriorityChart = null;
        }
        
        return view('admin.project.admin_project_single', compact('project', 'projectIssueStatusChart', 'projectIssuePriorityChart', 'totalIssues', 'openIssues', 'issuesInProgress', 'totalLoggedTime', 'timeProgress', 'offers', 'recentOffer'));
    }

    public function DeleteProject($id)
    {
        try {
            $project = Project::findOrFail($id);
            $user = Auth::user();
            
            // Check if user is assigned to this project (directly or through teams)
            if (!$user->isAssignedToProject($project->id)) {
                abort(403, 'You do not have permission to delete this project.');
            }
            
            $project->delete();
            
            return redirect()->route('admin.projects')->with([
                'message' => 'Project deleted successfully!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.projects')->with([
                'message' => 'Failed to delete project!',
                'alert-type' => 'error'
            ]);
        }
    }

    public function ShowSingleProjectEdit($id)
    {
        $project = Project::findOrFail($id);
        $statuses = ProjectStatus::all();
        $priorities = ProjectPriority::all();
        $companies = Company::all();
        $availableCustomers = Customer::all(); // Pass all customers instead of just project's company customers

        return view('admin.project.admin_project_edit', compact('project', 'statuses', 'priorities', 'companies', 'availableCustomers'));
    }

    public function UpdateProject($id, Request $request)
    {        
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'status_id' => 'required|exists:project_statuses,id',
            'priority_id' => 'required|exists:project_priorities,id',
            'color' => 'nullable|string|max:7',
            'budget' => 'nullable|decimal:0,2|min:0',
            'company_id' => 'required|exists:companies,id',
            'customer_id' => 'nullable|exists:customers,id',
        ], [
            'name.required' => __('Please set a name'),
            'name.max' => __('The name must be less than 255 characters'),
            'status_id.required' => __('Please set a status'),
            'priority_id.required' => __('Please set a priority'),
            'budget.min' => __('The budget must be greater than 0'),
            'budget.decimal' => __('The budget must be a decimal number with 2 decimal places'),
            'company_id.required' => __('Please select a company'),
            'customer_id.exists' => __('Please select a valid contact person'),
        ]);

        // Custom validation: customer must belong to the selected company
        if ($request->customer_id && $request->company_id) {
            $customer = Customer::find($request->customer_id);
            if ($customer && $customer->company_id != $request->company_id) {
                return redirect()->back()
                    ->withErrors(['customer_id' => __('The selected contact person does not belong to the selected company.')])
                    ->withInput();
            }
        }

        $project = Project::findOrFail($id);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => $request->status_id,
            'priority_id' => $request->priority_id,
            'color' => $request->color,
            'due_date' => $request->due_date,
            'budget' => $request->budget,
            'company_id' => $request->company_id,
            'customer_id' => $request->customer_id,
        ]);

        return redirect()->back()->with([
            'message' => 'Project updated successfully!',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Get customers for a specific company (API endpoint)
     */
    public function getCustomersByCompany($companyId)
    {
        $customers = Customer::where('company_id', $companyId)
                            ->where('status', 'active')
                            ->orderBy('name')
                            ->get(['id', 'name', 'email']);
        
        return response()->json($customers);
    }

    public function getCustomerById($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        return response()->json($customer);
    }

    public function CompleteProject($id)
    {
        $project = Project::findOrFail($id);
        $project->status_id = 4;
        $project->save();
        return redirect()->back()->with([
            'message' => 'Project completed successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function HoldProject($id)
    {
        $project = Project::findOrFail($id);
        $project->status_id = 3;
        $project->save();
        return redirect()->back()->with([
            'message' => 'Project put on hold successfully!',
            'alert-type' => 'success'
        ]);
    }

    public function ShowCreateProject()
    {
        $statuses = ProjectStatus::all();
        $priorities = ProjectPriority::all();
        $companies = Company::all();
        $availableCustomers = Customer::all();
        return view('admin.project.admin_project_create', compact('statuses', 'priorities', 'companies', 'availableCustomers'));
    }

    public function CreateProject(Request $request)
    {
        
    }
}
