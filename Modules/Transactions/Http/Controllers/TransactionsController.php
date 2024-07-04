<?php

namespace Modules\Transactions\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Students\Models\Student;
use Modules\Transactions\Models\Transaction;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class TransactionsController extends Controller
{
    public function index()
    {
        $x['title']     = "Transaction";
        $x['data']      = Transaction::with('user.student', 'program')->get();

        return view('transactions::index', $x);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        try {
            $transaction = Transaction::create([
                'name'      => $request->name
            ]);
            Alert::success('Pemberitahuan', 'Data <b>' . $transaction->name . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $transaction->name . '</b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show(Request $request)
    {
        $transaction = Transaction::with('user.student', 'program')->find($request->id);
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data transaction by id',
            'data'      => $transaction
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        try {
            $transaction = Transaction::find($request->id);
            $transaction->update([
                'name'  => $request->name
            ]);
            Alert::success('Pemberitahuan', 'Data <b>' . $transaction->name . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $transaction->name . '</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $transaction = Transaction::find($request->id);
            $transaction->delete();
            Alert::success('Pemberitahuan', 'Data <b>' . $transaction->name . '</b> berhasil dihapus')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $transaction->name . '</b> gagal dihapus : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function detail($id)
    {
        $x['title']         = "Detail Transaction";
        $x['transaction']   = Transaction::with('user.student', 'program')->find($id);

        return view('transactions::detail', $x);
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_active'      => ['nullable', 'integer'],
            'is_member'      => ['nullable', 'integer']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $student = Student::where('user_id', $request->user_id)->first();
            $student->update([
                'is_member'  => $request->is_member
            ]);

            $user = User::where('id', $request->user_id)->first();
            $user->update([
                'is_active'  => $request->is_active
            ]);

            DB::commit();
            Alert::success('Pemberitahuan', 'Data berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
}
