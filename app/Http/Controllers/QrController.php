<?php

namespace App\Http\Controllers;

use App\Models\BasisOfReturn;
use App\Models\Documents;
use App\Models\Offices;
use App\Models\TrackingHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LackingDocuments;
use App\Models\PrimaryReasonOfReturn;
use App\Models\User;
use App\Mail\DocumentReceivedNotification;
use App\Mail\DocumentUpdateMailer;
use Illuminate\Support\Facades\Mail;
use Google\Service\Docs\Document;
use Illuminate\Support\Carbon;

class QrController extends Controller
{
    //
    public function index(){
        return Documents::all();
    }

    public function qrInfo($referenceNo)
    {
        //Display Office on the Actions Area
        if (auth()->check())
        {
            $assignedOffice = User::join('offices', 'assignedOffice', '=', 'offices.id')
            ->where('assignedOffice', Auth::user()->assignedOffice)
            ->first();



        $documents_query = Documents::where('referenceNo', $referenceNo);
        $document_id = $documents_query->pluck('id')->first();

        // Fetch all offices that should appear as a dropdown selection.
        $selectOffice = Offices::where('status', '1')->get();


        // Fetch all offices from DB.
        $offices = Offices::all();

        $data = Documents::join('offices as sender', 'sender.id', '=', 'documents.senderOffice_id')
        ->join('offices as receiver', 'receiver.id', '=', 'documents.receiverOffice_id')
        ->select('documents.*', 'sender.officeName as senderOfficeName', 'receiver.officeName as receiverOfficeName')
        ->where('referenceNo', 'LIKE', "%{$referenceNo}%")
        ->latest()
        ->first();

        // Fetch document type data from DB using reference no.
        $docCategory = DB::table('documents')
                     ->join('document_type', 'documents.docType', 'document_type.id')
                     ->where('referenceNo','LIKE', "%{$referenceNo}%")
                     ->first();

        // Fetch tracking log info from DB using reference no, sorted by newest to oldest.
        $latestTracking = TrackingHistory::join('offices as sender', 'sender.id', '=', 'tracking_histories.senderOffice')
        ->join('users as user', 'user.id', '=', 'tracking_histories.user_id')
        ->join('offices as receiver', 'receiver.id', '=', 'tracking_histories.receiverOffice')
        ->select('tracking_histories.*', 'sender.officeName as senderOfficeName', 'receiver.officeName as receiverOfficeName', 'user.name as userName')
        ->where('referenceNo', 'LIKE', "%{$referenceNo}%")
        ->latest()
        ->first();

        $primaryReason = PrimaryReasonOfReturn::all();

        $lacking         = LackingDocuments::all();

        //Query Tracking history of a Document
        $latestResult = TrackingHistory::where('referenceNo', $referenceNo)
                        ->max('created_at');

        $latestResultRow = TrackingHistory::join('offices as sender', 'sender.id', '=', 'tracking_histories.senderOffice')
                        ->join('offices as receiver', 'receiver.id', '=', 'tracking_histories.receiverOffice')
                        ->join('users as user', 'user.id', '=', 'tracking_histories.user_id')
                        ->select('tracking_histories.*', 'sender.officeName as senderOfficeName', 'receiver.officeName as receiverOfficeName', 'user.name as userName')
                        ->where('referenceNo', $referenceNo)
                        ->where('tracking_histories.created_at', $latestResult)
                        ->latest()
                        ->first();

        $trackingHistory = TrackingHistory::join('offices as sender', 'sender.id', '=', 'tracking_histories.senderOffice')
                            ->join('offices as receiver', 'receiver.id', '=', 'tracking_histories.receiverOffice')
                            ->join('users as user', 'user.id', '=', 'tracking_histories.user_id')
                            ->select('tracking_histories.*', 'sender.officeName as senderOfficeName', 'receiver.officeName as receiverOfficeName', 'user.name as userName')
                            ->where('referenceNo', $referenceNo)
                            ->where('tracking_histories.created_at', '<', $latestResult)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Fetch status info from DB using reference number.
        $status = Documents::where('referenceNo', $referenceNo)->first();

        $getRecentOffice = TrackingHistory::where('referenceNo', $referenceNo)
                    ->select('user_id',
                        DB::raw('MAX(created_at) as latest_date'),
                        DB::raw('COUNT(*) as num_results'))
                    ->where('referenceNo', '=', $referenceNo)
                    ->groupBy('user_id')
                    ->orderByDesc('latest_date')
                    ->skip(1)
                    ->take(1)
                    ->first();


        $getDocumentCreator = Documents::where('referenceNo', $referenceNo)->first();

        $documentWithIssue = BasisOfReturn::join('primary_reason_of_returns as reason', 'reason.id', '=', 'basis_of_returns.primary_reason_of_return_id')
                            ->select('basis_of_returns.*', 'reason.reason as primary')
                            ->where('referenceNumber', $referenceNo)->latest()->first();


        $serializedData = BasisOfReturn::where('referenceNumber', $referenceNo)
                        ->where('primary_reason_of_return_id', 1)
                        ->pluck('lacking_doc_id');

        // dd($serializedData);
        $unserialized = $serializedData->map(function($item)
        {
            return unserialize($item);
        });

        // dd($serializedData);

    return view('users.qrinfo', ['trackingHistory'=> $trackingHistory])
        ->with('latestResultRow', $latestResultRow)
        ->with('assignedOffice', $assignedOffice)
        ->with('status', $status)
        ->with('offices', $offices)
        ->with('docCategory', $docCategory)
        ->with('data', $data)
        ->with('getDocumentCreator', $getDocumentCreator)
        ->with('documentWithIssue', $documentWithIssue)
        ->with('latestTracking', $latestTracking)
        ->with(['selectOffice' => $selectOffice])
        ->with(['lacking'=> $lacking])
        ->with(['primaryReason'=> $primaryReason])
        ->with(['boxArray' => $unserialized])
        ->with('getRecentOffice', $getRecentOffice);
        }
        else
        {
            // user is not logged in, redirect to login page
            return redirect()->route('login');
        }

    }


    public function search(Request $request)
    {
        //
        $output = "";
        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
    // $prefix = strval(strftime("%Y%m%d"));
        $month = strval(strftime("%M"));
            $day = strval(strftime("%D"));
            $stringVal = strval($number);
            // $refNo = "$prefix$stringVal";

            $senderOffice = Auth::user()->assignedOffice;

            if($senderOffice < 10)
            {
                $extraZero = '0';
                $refNo = "$prefix$extraZero$senderOffice$stringVal";
            }
             else{
                $refNo = "$prefix$senderOffice$stringVal";
            }


        return view('users.add', compact('refNo'));
    }

    public function altSearch(Request $request)
    {
        $search = $request->input('search');

        if($request->ajax())
        {
            $output = "";
            $results = DB::table('users')
            ->join('offices', 'assignedOffice', 'offices.id')
            ->where('name', $search )
            ->orWhere('email',$search )
            ->orwhere('phone',$search )
            ->get();
        }
        return response($results);
    }

    public function receiveDoc($referenceNo, Request $request)
    {
        $getRecentReceiver = TrackingHistory::where('referenceNo', $referenceNo)
                    ->latest()
                    ->first();

         if(isset($getRecentReceiver))
         {
            $checkIfExist = TrackingHistory::where('referenceNo', $referenceNo)
                        ->where('user_id', $getRecentReceiver->user_id)
                        ->where(function ($query) {
                            $query->where('status', 2)->orWhere('status', 8)->orWhere('status', 4);
                        })
                        ->latest()
                        ->first();
        }

        if(isset($getRecentReceiver) && $getRecentReceiver->user_id == Auth::user()->id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the previous receiver/owner of this document, modifying the document status is not allowed.');
        }
        else
        {
            $document = Documents::where('referenceNo', $referenceNo)->first();

            if(Auth::user()->id == $document->user_id && $document->senderOffice_id == Auth::user()->assignedOffice)
            {
                return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
            }
            else
            {
                $validatedData = $request->validate([
                    'status' => 'required',
                    'user_id' => 'required',
                    'action' => 'required',
                    'senderOffice' => 'required',
                ]);

                $sender = Offices::where('id', $validatedData['senderOffice'])->first();
                $receiver = Offices::where('id', $document->receiverOffice_id)->first();

                $user = User::findOrFail($document->user_id);
                $status = $validatedData['status'];
                $senderOffice = $sender->officeName;
                $receiverOffice = $receiver->officeName;;
                $date = Carbon::now()->format('F j, Y');
                $time = Carbon::now()->format('h:i A');

                Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                TrackingHistory::create([
                    'user_id' => $validatedData['user_id'],
                    'referenceNo' => $referenceNo,
                    'receiverOffice' => $document->receiverOffice_id,
                    'senderOffice' => $validatedData['senderOffice'],
                    'action' => $validatedData['action'],
                    'status' => $validatedData['status'],
                ]);

                Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

                return redirect('qrinfo/'.$referenceNo)->with('message', 'Document status updated as "RECEIVED"');
            }
        }
    }

    public function processDoc($referenceNo, Request $request)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->id == $document->user_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $latestResult = TrackingHistory::where('referenceNo', $referenceNo)
                    ->max('created_at');

            $latestResultRow = TrackingHistory::where('referenceNo', $referenceNo)
                    ->where('created_at', $latestResult)
                    ->latest()
                    ->first();

            if($latestResultRow->user_id == Auth::user()->id && $latestResultRow->status == 2)
            {
                $validatedData = $request->validate([
                    'user_id' => 'required',
                    'status' => 'required',
                    'action' => 'required',
                    'senderOffice' => 'required',
                ]);

                Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                TrackingHistory::create([
                    'user_id' => $validatedData['user_id'],
                    'referenceNo' => $referenceNo,
                    'receiverOffice' => $document->receiverOffice_id,
                    'senderOffice' => $validatedData['senderOffice'],
                    'action' => $validatedData['action'],
                    'status' => $validatedData['status'],
                ]);

                $sender = Offices::where('id', $validatedData['senderOffice'])->first();
                $receiver = Offices::where('id', $document->receiverOffice_id)->first();

                $user = User::findOrFail($document->user_id);
                $status = $validatedData['status'];
                $senderOffice = $sender->officeName;
                $receiverOffice = $receiver->officeName;;
                $date = Carbon::now()->format('F j, Y');
                $time = Carbon::now()->format('h:i A');

                Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

                return redirect('qrinfo/'.$referenceNo)->with('message', 'Document status updated as "PROCESSING"');
            }
            else
            {
                return redirect('qrinfo/'.$referenceNo)->with('error', "This document is currently received by another office.");
            }
        }
    }

    public function forwardDoc($referenceNo, Request $request)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->assignedOffice == $document->senderOffice_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $latestResult = TrackingHistory::where('referenceNo', $referenceNo)
                    ->max('created_at');

            $latestResultRow = TrackingHistory::where('referenceNo', $referenceNo)
                    ->where('created_at', $latestResult)
                    ->latest()
                    ->first();

            if($latestResultRow->senderOffice == Auth::user()->assignedOffice && $latestResultRow->status == 3)
            {
                $validatedData = $request->validate([
                    'status' => 'required',
                    'action' => 'required',
                    'senderOffice' => 'required',
                    'receiverOffice' => 'required',
                    'user_id'=> 'required',
                ]);

                if(Auth::user()->assignedOffice == $validatedData['receiverOffice'])
                {
                    return redirect('qrinfo/'.$referenceNo)->with('error', "You can't forward this Document to yourself");
                }
                else{
                Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                TrackingHistory::create([
                    'user_id' => $validatedData['user_id'],
                    'referenceNo' => $referenceNo,
                    'receiverOffice' => $validatedData['receiverOffice'],
                    'senderOffice' => $validatedData['senderOffice'],
                    'action' => $validatedData['action'],
                    'status' => $validatedData['status'],
                ]);

                $sender = Offices::where('id', $validatedData['senderOffice'])->first();
                $receiver = Offices::where('id', $validatedData['receiverOffice'])->first();

                $user = User::findOrFail($document->user_id);
                $status = $validatedData['status'];
                $senderOffice = $sender->officeName;
                $receiverOffice = $receiver->officeName;;
                $date = Carbon::now()->format('F j, Y');
                $time = Carbon::now()->format('h:i A');

                Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

                return redirect('qrinfo/'.$referenceNo)->with('message', 'Document status updated as "FORWARDED"');
                }
            }
            else{
                return redirect('qrinfo/'.$referenceNo)->with('error', "This document is being processed by another office.");
            }
        }
    }

    public function rejectDocument($referenceNo, Request $request)
    {
        $previousUser = DB::table('tracking_histories')
        ->select('user_id',
            DB::raw('MAX(created_at) as latest_date'),
            DB::raw('COUNT(*) as num_results'))
        ->where('referenceNo', '=', $referenceNo)
        ->groupBy('user_id')
        ->orderByDesc('latest_date')
        ->skip(1)
        ->take(1)
        ->first();

        $previousOffice = DB::table('tracking_histories')
        ->where('referenceNo', $referenceNo)
        ->where('user_id', $previousUser->user_id)
        ->orderByDesc('created_at')
        ->pluck('senderOffice')
        ->first();

        // dd($previousOffice);
        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->assignedOffice == $document->senderOffice_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $latestResultRow = TrackingHistory::where('referenceNo', $referenceNo)
                    ->latest()
                    ->first();

            if($latestResultRow->senderOffice == Auth::user()->assignedOffice && $latestResultRow->status == 3)
            {
                $rules = [
                    'primary_reason_of_return_id' => 'required | max:1',
                    'status' => 'required',
                    'action' => 'required',
                    'senderOffice_id' => 'required',
                    'receiverOffice_id' => 'required',
                    'others' => 'nullable',
                    'user_id'=> 'required',
                ];

                $messages = [
                    'primary_reason_of_return_id.required' => 'Choose a primary reason of rejection',
                    'primary_reason_of_return_id.unique' => 'Already Exists',
                ];

                $validatedData = $request->validate($rules, $messages);

                $data = serialize($request->input('lacking_doc_id'));
                if($validatedData['primary_reason_of_return_id'] == 1 && $data == "N;")
                {
                    return redirect('qrinfo/'.$referenceNo)->with('error', 'Check the boxes that is missing with the document.');
                }
                elseif($validatedData['primary_reason_of_return_id'] != 1)
                {
                    Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                    TrackingHistory::create([
                        'referenceNo' => $referenceNo,
                        'receiverOffice' => $previousOffice,
                        'senderOffice' => $validatedData['senderOffice_id'],
                        'action' => $validatedData['action'],
                        'status' => $validatedData['status'],
                        'user_id'=> $validatedData['user_id'],
                    ]);

                    $sender = Offices::where('id', $validatedData['senderOffice_id'])->first();
                    $receiver = Offices::where('id', $previousOffice)->first();

                    $user = User::findOrFail($previousUser->user_id);
                    $status = $validatedData['status'];
                    $senderOffice = $sender->officeName;
                    $receiverOffice = $receiver->officeName;;
                    $date = Carbon::now()->format('F j, Y');
                    $time = Carbon::now()->format('h:i A');

                    Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

                    $basis = new BasisOfReturn();
                    $basis->referenceNumber = $referenceNo;
                    $basis->primary_reason_of_return_id = $validatedData['primary_reason_of_return_id'];
                    $basis->user_id = $validatedData['user_id'];
                    $basis->others = $validatedData['others'];
                    $basis->save();
                }
                else{
                    Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                    TrackingHistory::create([
                        'referenceNo' => $referenceNo,
                        'receiverOffice' => $previousOffice,
                        'senderOffice' => $latestResultRow->senderOffice,
                        'action' => $validatedData['action'],
                        'status' => $validatedData['status'],
                        'user_id'=> $validatedData['user_id'],
                    ]);

                    $sender = Offices::where('id', $latestResultRow->senderOffice)->first();
                    $receiver = Offices::where('id', $previousOffice)->first();

                    $user = User::findOrFail($previousUser->user_id);
                    $status = $validatedData['status'];
                    $senderOffice = $sender->officeName;
                    $receiverOffice = $receiver->officeName;;
                    $date = Carbon::now()->format('F j, Y');
                    $time = Carbon::now()->format('h:i A');

                    Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

                    $basis = new BasisOfReturn();
                    $basis->referenceNumber = $referenceNo;
                    $basis->primary_reason_of_return_id = $validatedData['primary_reason_of_return_id'];
                    $basis->lacking_doc_id = $data;
                    $basis->user_id = $validatedData['user_id'];
                    $basis->others = $validatedData['others'];
                    $basis->save();
                }

                return redirect('qrinfo/'.$referenceNo)->with('message', 'This Document has been rejected by You');
            }
            else {
                return redirect('qrinfo/'.$referenceNo)->with('error', 'This Document is being processed by another office.');
            }
        }
    }

    public function returnToSender($referenceNo, Request $request)
    {
        $previousUser = DB::table('tracking_histories')
        ->select('user_id',
            DB::raw('MAX(senderOffice) as max_senderOffice'),
            DB::raw('MAX(created_at) as latest_date'),
            DB::raw('COUNT(*) as num_results'))
        ->where('referenceNo', '=', $referenceNo)
        ->groupBy('user_id')
        ->orderByDesc('latest_date')
        ->skip(1)
        ->take(1)
        ->first();

        $getRecentSender = TrackingHistory::where('referenceNo', $referenceNo)
        ->where('status', 5)
        ->latest()
        ->first();

        // dd($getRecentSender);

        $checkIfExist = TrackingHistory::where('referenceNo', $referenceNo)
            ->where('status', 5)
            ->where('senderOffice', $getRecentSender->senderOffice)
            ->latest()
            ->first();

        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->id == $document->user_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $latestResult = TrackingHistory::where('referenceNo', $referenceNo)
                    ->max('created_at');

            $latestResultRow = TrackingHistory::where('referenceNo', $referenceNo)
                    ->where('created_at', $latestResult)
                    ->latest()
                    ->first();

            if($latestResultRow->senderOffice == Auth::user()->assignedOffice && $latestResultRow->status == 5)
            {
                $validatedData = $request->validate([
                    'status' => 'required',
                    'action' => 'required',
                    'senderOffice' => 'required',
                    'user_id' => 'required'
                ]);

                Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                TrackingHistory::create([
                    'referenceNo' => $referenceNo,
                    'receiverOffice' => $getRecentSender->receiverOffice,
                    'senderOffice' => $validatedData['senderOffice'],
                    'action' => $validatedData['action'],
                    'status' => $validatedData['status'],
                    'user_id' => $validatedData['user_id'],
                ]);

                $sender = Offices::where('id', $validatedData['senderOffice'])->first();
                $receiver = Offices::where('id', $getRecentSender->receiverOffice)->first();

                $user = User::findOrFail($previousUser->user_id);
                $status = $validatedData['status'];
                $senderOffice = $sender->officeName;
                $receiverOffice = $receiver->officeName;;
                $date = Carbon::now()->format('F j, Y');
                $time = Carbon::now()->format('h:i A');

                Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

                return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is being returned to the sender by You');
            }
            else{
                return redirect('qrinfo/'.$referenceNo)->with('error', 'This document is currently in another office.');
            }
        }
    }

    public function resolveDoc($referenceNo, Request $request)
    {
        $latestResult = TrackingHistory::where('referenceNo', $referenceNo)
                    ->where('status', 6)
                    ->latest()
                    ->first();

        if(Auth::user()->assignedOffice !=  $latestResult->receiverOffice)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'Only the previous receiver can resolve this document.');
        }
        else
        {

            $validatedData = $request->validate([
                'status' => 'required',
                'action' => 'required',
                'senderOffice' => 'required',
                'user_id' => 'required',
            ]);

            Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

            TrackingHistory::create([
                'referenceNo' => $referenceNo,
                'receiverOffice' => $latestResult->senderOffice,
                'senderOffice' => $validatedData['senderOffice'],
                'action' => $validatedData['action'],
                'status' => $validatedData['status'],
                'user_id' => $validatedData['user_id'],
            ]);

            $sender = Offices::where('id', $validatedData['senderOffice'])->first();
            $receiver = Offices::where('id', $latestResult->senderOffice)->first();

            $user = User::findOrFail($latestResult->user_id);
            $status = $validatedData['status'];
            $senderOffice = $sender->officeName;
            $receiverOffice = $receiver->officeName;
            $date = Carbon::now()->format('F j, Y');
            $time = Carbon::now()->format('h:i A');

            Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

            return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is being resolved');
        }
    }

    public function resubmitDoc($referenceNo, Request $request)
    {
        $previousUser = DB::table('tracking_histories')
        ->select('user_id',
            DB::raw('MAX(receiverOffice) as recv_office'),
            DB::raw('MAX(status) as stats'),
            DB::raw('MAX(senderOffice) as max_senderOffice'),
            DB::raw('MAX(created_at) as latest_date'),
            DB::raw('COUNT(*) as num_results'))
        ->where('referenceNo', '=', $referenceNo)
        ->groupBy('user_id')
        ->orderByDesc('latest_date')
        ->skip(1)
        ->take(1)
        ->first();

        $latestResult = TrackingHistory::where('referenceNo', $referenceNo)
                    ->where('status', 7)
                    ->latest()
                    ->first();

        if(Auth::user()->assignedOffice != $latestResult->senderOffice)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'Only the creator can resubmit this document.');
        }
        else
        {
            $validatedData = $request->validate([
                'status' => 'required',
                'action' => 'required',
                'senderOffice' => 'required',
                'user_id' => 'required'
            ]);

            Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

            // BasisOfReturn::where('referenceNumber', $referenceNo)->delete();

            TrackingHistory::create([
                'referenceNo' => $referenceNo,
                'receiverOffice' => $previousUser->max_senderOffice,
                'senderOffice' => $validatedData['senderOffice'],
                'action' => $validatedData['action'],
                'status' => $validatedData['action'],
                'user_id' => $validatedData['user_id'],
            ]);

            $sender = Offices::where('id', $validatedData['senderOffice'])->first();
            $receiver = Offices::where('id', $previousUser->max_senderOffice)->first();

            $user = User::findOrFail($previousUser->user_id);
            $status = $validatedData['action'];
            $senderOffice = $sender->officeName;
            $receiverOffice = $receiver->officeName;;
            $date = Carbon::now()->format('F j, Y');
            $time = Carbon::now()->format('h:i A');

            Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

            return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is being resubmitted');
        }
    }
    public function approveAndKeep($referenceNo, Request $request)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        $latestResult = TrackingHistory::where('referenceNo', $referenceNo)
            ->where('status', 2)
            ->latest()
            ->first();

        if($document->receiverOffice_id && Auth::user()->assignedOffice)
        {
            $validatedData = $request->validate([
                'status' => 'required',
                'action' => 'required',
                'senderOffice' => 'required',
                'user_id' => 'required'
            ]);

            Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

            TrackingHistory::create([
                'referenceNo' => $referenceNo,
                'receiverOffice' => $document->receiverOffice_id,
                'senderOffice' => $validatedData['senderOffice'],
                'action' => $validatedData['action'],
                'status' => $validatedData['status'],
                'user_id' => $validatedData['user_id'],
            ]);

            $sender = Offices::where('id', $validatedData['senderOffice'])->first();
            $receiver = Offices::where('id', $document->receiverOffice_id)->first();

            $user = User::findOrFail($document->user_id);
            $status = $validatedData['status'];
            $senderOffice = $sender->officeName;
            $receiverOffice = $receiver->officeName;;
            $date = Carbon::now()->format('F j, Y');
            $time = Carbon::now()->format('h:i A');

            Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

            return redirect('qrinfo/'.$referenceNo)->with('message', "This document is now approved and will be kept in this office. This is the end of the document's life cycle.");
        }
        else {
            return redirect('qrinfo/'.$referenceNo)->with('message', "Hmmm, something is wrong. You can't modify this document.");
        }
    }

    public function approveAndReturn(Request $request, $referenceNo)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->id == $document->user_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $latestResult = TrackingHistory::where('referenceNo', $referenceNo)
                    ->max('created_at');

            $latestResultRow = TrackingHistory::where('referenceNo', $referenceNo)
                    ->where('created_at', $latestResult)
                    ->latest()
                    ->first();

            if($latestResultRow->senderOffice == Auth::user()->assignedOffice)
            {
                $validatedData = $request->validate([
                    'status' => 'required',
                    'action' => 'required',
                    'senderOffice' => 'required',
                    'user_id' => 'required'
                ]);

                Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                TrackingHistory::create([
                    'referenceNo' => $referenceNo,
                    'receiverOffice' => $document->senderOffice_id,
                    'senderOffice' => $validatedData['senderOffice'],
                    'action' => $validatedData['action'],
                    'status' => $validatedData['status'],
                    'user_id' => $validatedData['user_id'],
                ]);

                $sender = Offices::where('id', $validatedData['senderOffice'])->first();
                $receiver = Offices::where('id', $document->senderOffice_id)->first();

                $user = User::findOrFail($document->user_id);
                $status = $validatedData['status'];
                $senderOffice = $sender->officeName;
                $receiverOffice = $receiver->officeName;;
                $date = Carbon::now()->format('F j, Y');
                $time = Carbon::now()->format('h:i A');

                Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

                return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is being returned to the sender by You');
            }
            else{
                return redirect('qrinfo/'.$referenceNo)->with('error', 'This document is currently in another office.');
            }
        }
    }

    public function rejectedReturnToPrevious(Request $request, $referenceNo)
    {
        $previousUser = DB::table('tracking_histories')
        ->select('user_id',
            DB::raw('MAX(senderOffice) as max_senderOffice'),
            DB::raw('MAX(created_at) as latest_date'),
            DB::raw('COUNT(*) as num_results'))
        ->where('referenceNo', '=', $referenceNo)
        ->groupBy('user_id')
        ->orderByDesc('latest_date')
        ->skip(1)
        ->take(1)
        ->first();

        $getRecentSender = TrackingHistory::where('referenceNo', $referenceNo)
        ->where('status', 5)
        ->latest()
        ->first();

        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->id == $document->user_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $latestResult = TrackingHistory::where('referenceNo', $referenceNo)
                    ->max('created_at');

            $latestResultRow = TrackingHistory::where('referenceNo', $referenceNo)
                    ->where('created_at', $latestResult)
                    ->latest()
                    ->first();

                if($latestResultRow->senderOffice == Auth::user()->assignedOffice)
                {
                    $validatedData = $request->validate([
                        'status' => 'required',
                        'action' => 'required',
                        'senderOffice' => 'required',
                        'user_id' => 'required'
                    ]);

                    Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                    TrackingHistory::create([
                        'referenceNo' => $referenceNo,
                        'receiverOffice' => $previousUser->max_senderOffice,
                        'senderOffice' => $validatedData['senderOffice'],
                        'action' => $validatedData['action'],
                        'status' => $validatedData['status'],
                        'user_id' => $validatedData['user_id'],
                    ]);

                    $sender = Offices::where('id', $validatedData['senderOffice'])->first();
                    $receiver = Offices::where('id', $previousUser->max_senderOffice)->first();

                    $user = User::findOrFail($previousUser->user_id);
                    $status = $validatedData['status'];
                    $senderOffice = $sender->officeName;
                    $receiverOffice = $receiver->officeName;;
                    $date = Carbon::now()->format('F j, Y');
                    $time = Carbon::now()->format('h:i A');

                    Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

                    return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is being returned to the sender by You');
                }
                else{
                    return redirect('qrinfo/'.$referenceNo)->with('error', 'This document is currently in another office.');
                }
        }
    }

    public function rejectedReturnToSender(Request $request, $referenceNo)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->id == $document->user_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $latestResult = TrackingHistory::where('referenceNo', $referenceNo)
                    ->max('created_at');

            $latestResultRow = TrackingHistory::where('referenceNo', $referenceNo)
                    ->where('created_at', $latestResult)
                    ->latest()
                    ->first();

            if($latestResultRow->senderOffice == Auth::user()->assignedOffice)
            {
                $validatedData = $request->validate([
                    'status' => 'required',
                    'action' => 'required',
                    'senderOffice' => 'required',
                    'user_id' => 'required'
                ]);

                Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                TrackingHistory::create([
                    'referenceNo' => $referenceNo,
                    'receiverOffice' => $document->senderOffice_id,
                    'senderOffice' => $validatedData['senderOffice'],
                    'action' => $validatedData['action'],
                    'status' => $validatedData['status'],
                    'user_id' => $validatedData['user_id'],
                ]);

                $sender = Offices::where('id', $validatedData['senderOffice'])->first();
                $receiver = Offices::where('id', $document->receiverOffice_id)->first();

                $user = User::findOrFail($document->user_id);
                $status = $validatedData['status'];
                $senderOffice = $sender->officeName;
                $receiverOffice = $receiver->officeName;;
                $date = Carbon::now()->format('F j, Y');
                $time = Carbon::now()->format('h:i A');

                Mail::send(new DocumentUpdateMailer($user, $referenceNo, $status, $senderOffice, $receiverOffice, $date, $time));

                return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is being returned to the sender by You');
            }
            else{
                return redirect('qrinfo/'.$referenceNo)->with('error', 'This document is currently in another office.');
            }
        }
    }

    public function receiveToKeep(Request $request, $referenceNo)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        $validatedData = $request->validate([
            'status' => 'required',
            'action' => 'required',
            'senderOffice' => 'required',
            'user_id' => 'required'
        ]);

        if($document->user_id == Auth::user()->id)
        {
            Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                TrackingHistory::create([
                    'referenceNo' => $referenceNo,
                    'receiverOffice' => $document->senderOffice_id,
                    'senderOffice' => $validatedData['senderOffice'],
                    'action' => $validatedData['action'],
                    'status' => $validatedData['status'],
                    'user_id' => $validatedData['user_id'],
                ]);

            return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is now permanently stored');
        }
        else{
            return redirect('qrinfo/'.$referenceNo)->with('error', 'You do not have permission to keep this document');
        }
    }
}
