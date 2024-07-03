<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Programs\Models\Program;
use Modules\ProgramTypes\Models\ProgramType;
use Illuminate\Support\Facades\DB;
use Modules\Coupons\Models\Coupon;
use Modules\Students\Models\Student;
use Modules\Transactions\Models\Transaction;
use App\Notifications\SendNewUserNotification;
use App\Notifications\SendTransactionNotification;

class FrontController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');
    }

    function index()
    {
        $programTypes = ProgramType::with('program')->get();

        return view('front.index', compact('programTypes'));
    }

    function detail($id)
    {
        $program = Program::with('program_type')->findOrFail($id);

        return view('front.detail', compact('program'));
    }

    
    function coupon(Request $request)
    {
        $validated = $request->validate([
            'program_id'    => 'required|string|max:255',
            'coupon_code'   => 'required|string|max:255'
        ]);
        $coupon = Coupon::first();
        if($coupon == null) {
            return back()->with(['error' => 'Kupon tidak tersedia!'])->withInput();
        } elseif ($coupon->code == $request->coupon_code && $coupon->program_id == $request->program_id) {            
            return back()->with(['success' => 'Kupon diskon berhasil dipasang!'])->with(['couponAmount' => $coupon->amount])->with(['couponId' => $coupon->id]);
        } else {
            return back()->with(['error' => 'Kupon tidak tersedia!'])->withInput();
        }
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|unique:users|max:255',
            'phone_number'  => 'required',
            'gender'        => 'required|string',
            'address'       => 'required|string|max:255',
            'program_id'    => 'required'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('password'),
                'level'  => 2,
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address
            ]);

            $program = Program::where('id', $request->program_id)->first();
            $coupon = Coupon::where('id', $request->coupon_id)->first();
            if($coupon == null) {
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'total_purchases' => $program->price,
                    'maximum_payment_time' => Carbon::now()->addDays(1),
                    'code' => Transaction::generateCode(),
                    'transaction_status' => 'pending',
                    'invoice' => 'EB.' . date('dmy') . '.' . rand(1000, 9999),
                    'program_id' => $request->program_id,
                    'program_date' => $request->program_date,
                    'program_time' => $request->program_time,
                    'note' => $request->message,
                    'discount' => 0
                ]);
    
                $payload = [
                    'transaction_details' => [
                        'order_id'     => $transaction->invoice,
                        'gross_amount' => $program->price,
                    ],
                    'customer_details' => [
                        'first_name'    => $user->name,
                        'email'         => $user->email,
                    ],
                    'item_details' => [
                        [
                            'id'            => $transaction->invoice,
                            'price'         => $program->price,
                            'quantity'      => 1,
                            'name'          => 'Program ' . $program->name,
                            'brand'         => 'English Booster',
                            'category'      => 'English Course',
                            'merchant_name' => config('app.name'),
                        ],
                    ],
                ];
    
                $snapToken = \Midtrans\Snap::getSnapToken($payload);
                $transaction->snap_token = $snapToken;
                $transaction->save();
    
                $admin = User::find('20b2a4122c614bb68e41b1a6f3f37780');
                $admin->notify(new SendNewUserNotification($user));
    
                $message = "*Mohon dibaca dan dipahami!*\n\n_Hallo, saya admin dari English Booster Kampung Inggris, akun kamu telah terdaftar di platform kami dengan data_\n\nNama: " . $user->name . "\nEmail: " . $user->email . "\n\nBerikut link pembayaran dan verifikasi kamu\n" . env('APP_URL') . "/invoice/" . $transaction->id . "\n\n*Jika link tidak bisa diklik, silakan simpan dulu nomor ini atau copy dan paste dibrowser kamu.*\n\n_terimakasih telah menjadi bagian dari kami, semoga English Booster Kampung Inggris dapat membantu proses belajar kamu. aamiin._";
                sendWhatsappNotification($student->phone_number, $message);

            } elseif ($coupon->id == $request->coupon_id && $coupon->program_id == $request->program_id) {            
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'total_purchases' => $program->price,
                    'maximum_payment_time' => Carbon::now()->addDays(1),
                    'code' => Transaction::generateCode(),
                    'transaction_status' => 'pending',
                    'invoice' => 'EB.' . date('dmy') . '.' . rand(1000, 9999),
                    'program_id' => $request->program_id,
                    'program_date' => $request->program_date,
                    'program_time' => $request->program_time,
                    'note' => $request->message,
                    'discount' => $coupon->amount,
                ]);
    
                $payload = [
                    'transaction_details' => [
                        'order_id'     => $transaction->invoice,
                        'gross_amount' => $program->price - $coupon->amount,
                    ],
                    'customer_details' => [
                        'first_name'    => $user->name,
                        'email'         => $user->email,
                    ],
                    'item_details' => [
                        [
                            'id'            => $transaction->invoice,
                            'price'         => $program->price - $coupon->amount,
                            'quantity'      => 1,
                            'name'          => 'Program ' . $program->name,
                            'brand'         => 'English Booster',
                            'category'      => 'English Course',
                            'merchant_name' => config('app.name'),
                        ],
                    ],
                ];
    
                $snapToken = \Midtrans\Snap::getSnapToken($payload);
                $transaction->snap_token = $snapToken;
                $transaction->save();
    
                $admin = User::find('20b2a4122c614bb68e41b1a6f3f37780');
                $admin->notify(new SendNewUserNotification($user));
    
                $message = "*Mohon dibaca dan dipahami!*\n\n_Hallo, saya admin dari English Booster Kampung Inggris, akun kamu telah terdaftar di platform kami dengan data_\n\nNama: " . $user->name . "\nEmail: " . $user->email . "\n\nBerikut link pembayaran dan verifikasi kamu\n" . env('APP_URL') . "/invoice/" . $transaction->id . "\n\n*Jika link tidak bisa diklik, silakan simpan dulu nomor ini atau copy dan paste dibrowser kamu.*\n\n_terimakasih telah menjadi bagian dari kami, semoga English Booster Kampung Inggris dapat membantu proses belajar kamu. aamiin._";
                sendWhatsappNotification($student->phone_number, $message);

            } else {
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'total_purchases' => $program->price,
                    'maximum_payment_time' => Carbon::now()->addDays(1),
                    'code' => Transaction::generateCode(),
                    'transaction_status' => 'pending',
                    'invoice' => 'EB.' . date('dmy') . '.' . rand(1000, 9999),
                    'program_id' => $request->program_id,
                    'program_date' => $request->program_date,
                    'program_time' => $request->program_time,
                    'note' => $request->message,
                    'discount' => 0
                ]);
    
                $payload = [
                    'transaction_details' => [
                        'order_id'     => $transaction->invoice,
                        'gross_amount' => $program->price,
                    ],
                    'customer_details' => [
                        'first_name'    => $user->name,
                        'email'         => $user->email,
                    ],
                    'item_details' => [
                        [
                            'id'            => $transaction->invoice,
                            'price'         => $program->price,
                            'quantity'      => 1,
                            'name'          => 'Program ' . $program->name,
                            'brand'         => 'English Booster',
                            'category'      => 'English Course',
                            'merchant_name' => config('app.name'),
                        ],
                    ],
                ];
    
                $snapToken = \Midtrans\Snap::getSnapToken($payload);
                $transaction->snap_token = $snapToken;
                $transaction->save();
    
                $admin = User::find('20b2a4122c614bb68e41b1a6f3f37780');
                $admin->notify(new SendNewUserNotification($user));
    
                $message = "*Mohon dibaca dan dipahami!*\n\n_Hallo, saya admin dari English Booster Kampung Inggris, akun kamu telah terdaftar di platform kami dengan data_\n\nNama: " . $user->name . "\nEmail: " . $user->email . "\n\nBerikut link pembayaran dan verifikasi kamu\n" . env('APP_URL') . "/invoice/" . $transaction->id . "\n\n*Jika link tidak bisa diklik, silakan simpan dulu nomor ini atau copy dan paste dibrowser kamu.*\n\n_terimakasih telah menjadi bagian dari kami, semoga English Booster Kampung Inggris dapat membantu proses belajar kamu. aamiin._";
                sendWhatsappNotification($student->phone_number, $message);
            }            

            DB::commit();

            return redirect('payment/' . $transaction->id);
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ];
        }
    }

    function payment($id)
    {
        $transaction = Transaction::with('user.student')->findOrfail($id);
        
        return view('front.payment', compact('transaction'));
    }

    function success($id)
    {
        $transaction = Transaction::with('user.student')->findOrfail($id);

        return view('front.success', compact('transaction'));
    }
    
    public function midtransCallback(Request $request)
    {
        $json = json_decode($request->getContent());
        $transactionStatus = $json->transaction_status;
        $orderId = $json->order_id;

        if ($transactionStatus == 'settlement') {
            Transaction::where('invoice', $orderId)->update([
                'transaction_status' => 'paid',
            ]);
            $transaction = Transaction::where('invoice', $orderId)->first();

            $admin = User::find('20b2a4122c614bb68e41b1a6f3f37780');
            $admin->notify(new SendTransactionNotification($transaction));

            $message = "*Pembayaran Terverifikasi*\n\n_Terimakasih telah menjadi bagian dari kami, semoga English Booster Kampung Inggris dapat membantu proses belajar kamu. aamiin._";
            sendWhatsappNotification($transaction->user->student->phone_number, $message);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
             Transaction::where('invoice', $orderId)->update([
                'transaction_status' => 'failed',
            ]);

            $transaction = Transaction::where('invoice', $orderId)->first();

            $admin = User::find('20b2a4122c614bb68e41b1a6f3f37780');
            $admin->notify(new SendTransactionNotification($transaction));

            $message = "*Pembayaran Gagal*\n\n_Silahkan hubungi admin untuk proses pembayaran. Terima kasih._";
            sendWhatsappNotification($transaction->user->student->phone_number, $message);
        }
        
        return response()->json(['status' => 'success']);
    }
}
