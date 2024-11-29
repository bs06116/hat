<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use App\RolesEnum;
use App\UserStatus;
use Illuminate\Validation\Rules;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use Carbon\Carbon;
use App\JobStatus;
use App\Models\Invoice;
use Log;
use Hash;
use App\Jobs\SendInvoiceJob;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;



class InvoiceController extends Controller
{
    
  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        } 
        $invoices = Invoice::with('job')->get();     
        return view('site.invoice.index', compact('invoices'));
        // $invoice = Invoice::find(1); // Retrieve the invoice
        // $jobs = Job::where('status', JobStatus::COMPLETED->value)
        // ->whereHas('driversBids', function ($query) use ($invoice) { // Pass $invoice using 'use'
        //     $query->where('assigned', 1) // Filter only assigned bids
        //           ->where('driver_id', $invoice->driver_id); // Match driver ID from the invoice
        // })
        // ->get();
        // return view('email.invoice', compact('invoice','jobs'));
      
    }
    public function toggleApproval(Request $request)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $invoice = Invoice::findOrFail($request->invoice_id);
        // Toggle the is_approved status
        $invoice->is_approved = !$invoice->is_approved;
        $invoice->approved_by = $invoice->is_approved ? auth()->id() : null; // Set approved_by or remove it if unapproved
        $invoice->save();
        $invoice = Invoice::find($request->invoice_id); // Retrieve the invoice
        $jobs = Job::where('status', JobStatus::COMPLETED->value)
        ->whereHas('driversBids', function ($query) use ($invoice) { // Pass $invoice using 'use'
            $query->where('assigned', 1) // Filter only assigned bids
                  ->where('driver_id', $invoice->driver_id); // Match driver ID from the invoice
        })
        ->get();
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice', 'jobs'));
        // Save the PDF to a file
        $pdfPath = storage_path(path: "invoice_{$invoice->id}.pdf");
        $pdf->save($pdfPath);
       // SendInvoiceJob::dispatch($invoice, $jobs);
        return response()->json([
            'success' => true,
            'is_approved' => $invoice->is_approved,
            'message' => $invoice->is_approved ? 'Invoice approved successfully.' : 'Invoice unapproved successfully.',
        ]);
    }
    public function approvedInvoice(Request $request)
    {
        if (!Auth::user() || !Auth::user()->hasRole(RolesEnum::SITEDRIVER->value)) {
            abort(code: 403);
        } 
          $driver = auth()->user(); // Assuming the driver is authenticated
          $invoices = Invoice::with('job')
          ->where('driver_id', $driver->id)
          ->where('is_approved', 1)
          ->get();     
         return view('site.invoice.approved_invoices', compact('invoices'));
    }
    public function downloadPdf($invoiceId)
    {
        $filePath = storage_path("invoice_{$invoiceId}.pdf");
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    }
}
