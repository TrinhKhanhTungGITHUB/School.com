<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\SettingModel;
use App\Models\StudentAddFeesModel;
use App\Models\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExporCollectFees;

use Session;
use Stripe\Stripe;


class FeesCollectionController extends Controller
{
    public function CollectFees(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();

        $data['header_title'] = 'Collect Fees';

        // dd($request->all());


        if (session('error')) {
            Toastr::error('No Information Found  ', 'Error');
        } else if (session('updated')) {
            Toastr::success('Fees collection updated successfully', 'Message');
        } else if (session('deleted')) {
            Toastr::warning('Fees collection delete successfully ', 'Warning');
        } else {
            if (!empty($request->all())) {
                $data['getRecord'] = User::getCollectFeesStudent();
                if (User::getCollectFeesStudent()->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            }
        }
        return view('admin.fees_collection.collect_fees', $data);
    }

    public function CollectFeesAdd($student_id)
    {
        $data['header_title'] = 'Add Collect Fees';
        $getStudent = User::getSingle($student_id);
        if( empty($getStudent) ||$getStudent->user_type !=3 || empty($getStudent->class_id ))
        {
            Toastr::error('Error Enter','Message');
            return view('admin.fees_collection.add_collect_fees', $data);
        }
        $data['getStudent'] = User::getSingleClass($student_id);


        $data['getFees'] = StudentAddFeesModel::getFees($student_id);
        // dd(StudentAddFeesModel::getFees($student_id));


        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);

        if (session('error')) {
            Toastr::error('Your amount go to greater than remaining amount  ', 'Error');
        } else if (session('success')) {
            Toastr::success('Fees successfully Add', 'Message');
        } else if (session('error_enter')) {
            Toastr::error('Your need add your amount at least $1', 'Message');
        } else {
            Toastr::info('This is your payment history.', 'Message');
        }
        return view('admin.fees_collection.add_collect_fees', $data);
    }

    public function CollectFeesInsert($student_id, Request $request)
    {
        $getStudent = User::getSingleClass($student_id);
        $paid_amount = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);

        if (!empty($request->amount)) {
            $remainingAmount = $getStudent->amount - $paid_amount;
            if ($remainingAmount >= $request->amount) {
                $remaining_amount_user = $remainingAmount - $request->amount;

                $payment = new StudentAddFeesModel;
                $payment->student_id = $student_id;
                $payment->class_id = $getStudent->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $remainingAmount;
                $payment->remaining_amount = $remaining_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->is_payment = 1;
                $payment->created_by = Auth::user()->id;
                $payment->save();

                return redirect()->back()->with('success', 'Fees successfully Add');
            } else {
                return redirect()->back()->with('error', 'Your amount go to greater than remaining amount');
            }
        } else {
            return redirect()->back()->with('error_enter', 'Your need add your amount at least $1');
        }
    }


    public function CollectFeesReport()
    {
        $data['getRecord'] = StudentAddFeesModel::getRecord();
        $data['getClass'] = ClassModel::getClass();
        $data['header_title'] = "Collect Fees Report";

        return view('admin.fees_collection.collect_fees_report', $data);
    }


    public function ExportCollectFeesReport(Request $request)
    {
        return Excel::download(new ExporCollectFees, 'CollectFeesReport_' . date('d-m-Y H:i:s') . '.xlsx');
    }

    // student side work
    public function CollectFeesStudent(Request $request)
    {
        $student_id = Auth::user()->id;

        $data['getFees'] = StudentAddFeesModel::getFees($student_id);

        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;
        $data['header_title'] = 'Fees Collection ';
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);

        if (session('error')) {
            Toastr::error('Your amount go to greater than remaining amount  ', 'Error');
        } else if (session('success')) {
            Toastr::success('Fees successfully Add', 'Message');
        } else if (session('error_enter')) {
            Toastr::error('Your need add your amount at least $1', 'Message');
        } else if (session('error_payment')) {
            Toastr::error('Due to some error please try again', 'Message');
        } else if (session('success_stripe')) {
            Toastr::success('Your Payment Successfully', 'Message');
        } else {
            Toastr::info('This is your payment history.', 'Message');
        }
        return view('student.my_fees_collection', $data);
    }

    public function CollectFeesStudentPayment(Request $request)
    {
        $getStudent = User::getSingleClass(Auth::user()->id);
        $paid_amount = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);

        if (!empty($request->amount)) {
            $remainingAmount = $getStudent->amount - $paid_amount;
            if ($remainingAmount >= $request->amount) {
                $remaining_amount_user = $remainingAmount - $request->amount;

                $payment = new StudentAddFeesModel;
                $payment->student_id = Auth::user()->id;
                $payment->class_id = Auth::user()->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $remainingAmount;
                $payment->remaining_amount = $remaining_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->save();

                $getSetting = SettingModel::getSingle();
                if ($request->payment_type == 'Paypal') {
                    // $paypalId =
                    // $query = array();
                    // $query['business'] = $getSetting->paypal_email;
                    // $query['cmd'] = '_xclick';
                    // $query['item_name'] = "Student Fees";
                    // $query['no_shipping'] = '1';
                    // $query['item_number'] = $payment->id;
                    // $query['amount'] = $request->amount;
                    // $query['currency_code'] = 'USD';
                    // $query['cancel_return'] = url('student/paypal/payment-error');
                    // $query['return'] = url('student/paypal/payment-success');

                    // $query_string = http_build_query($query);
                    // //header('Location: https://www.paypal.com/cgi-bin/webscr?' .$query_string);
                    // header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?' . $query_string);
                    // exit();
                    
                } else if ($request->payment_type == 'Stripe') {
                    $setPublicKey = $getSetting->stripe_key;
                    $setApiKey = $getSetting->stripe_secret;

                    Stripe::setApiKey($setApiKey);
                    $finalprice = $request->amount * 100;

                    $session = \Stripe\Checkout\Session::create([
                        'customer_email' => Auth::user()->email,
                        'payment_method_types' => ['card'],
                        'line_items' => [[
                            'price_data' => [
                                'currency' => 'usd',
                                'product_data' => [
                                    'name' => 'Student Fees',
                                    // 'images' => [url('upload/setting/z4409385178286_5dfdd75cf5dd46cf9f68a09c01f06e7320231113145856bcj.jpg')],
                                ],
                                'unit_amount' => intval($finalprice),
                            ],
                            'quantity' => 1,
                            // 'name' => 'Student Fees',
                            // 'description'=>'Student Fees',
                            // 'amount' => intval($finalprice),

                            // 'quantity' => 1,
                        ]],

                        'mode' => 'payment',
                        'success_url' => url('student/stripe/payment-success'),
                        'cancel_url' => url('student/stripe/payment-error'),
                    ]);

                    $payment->stripe_session_id = $session['id'];
                    $payment->save();

                    $data['session_id'] = $session['id'];
                    Session::put('stripe_session_id', $session['id']);
                    $data['setPublicKey'] = $setPublicKey;

                    return view('stripe_charge', $data);
                }
                // return redirect()->back()->with('success', 'Fees successfully Add');
            } else {
                return redirect()->back()->with('error', 'Your amount go to greater than remaining amount');
            }
        } else {
            return redirect()->back()->with('error_enter', 'Your need add your amount at least $1');
        }
    }

    public function PaymentSuccess(Request $request)
    {
        dd($request->all());
    }
    public function PaymentError()
    {
        return redirect('student/fees_collection')->with('error_payment', 'Due to some error please try again');
    }

    public function PaymentSuccessStripe(Request $request)
    {
        $getSetting = SettingModel::getSingle();
        $setPublicKey = $getSetting->stripe_key;
        $setApiKey = $getSetting->stripe_secret;

        $trans_id = Session::get('stripe_session_id');
        $getFee = StudentAddFeesModel::where('stripe_session_id', '=', $trans_id)->first();

        Stripe::setApiKey($setApiKey);

        $getData = \Stripe\Checkout\Session::retrieve($trans_id);

        if (!empty($getData->id) && $getData->id == $trans_id && !empty($getFee) && $getData->status == 'complete' && $getData->payment_status == 'paid') {
            $getFee->is_payment = 1;
            $getFee->payment_data = json_encode($getData);
            $getFee->save();

            Session::forget('stripe_session_id');

            return redirect('student/fees_collection')->with('success_stripe', 'Your Payment Successfully');
        } else {
            return redirect('student/fees_collection')->with('error_payment', 'Due to some error please try again');
        }

    }
}
