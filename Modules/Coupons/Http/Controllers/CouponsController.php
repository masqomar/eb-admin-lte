<?php

namespace Modules\Coupons\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Modules\Coupons\Models\Coupon;
use Modules\Programs\Models\Program;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class CouponsController extends Controller
{
    public function index()
    {
        $x['title']     = "Coupon";
        $x['data']      = Coupon::get();

        return view('coupons::index', $x);
    }

    public function create()
    {
        $x['title']     = "Tambah Kupon Diskon";
        $x['data']      = Program::get();

        return view('coupons::create', $x);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'          => ['required', 'string', 'max:255'],
            'amount'        => ['required', 'integer'],
            'qty'           => ['required', 'integer'],
            'program_id'    => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        try {
            $coupon = Coupon::create([
                'code'          => $request->code,
                'amount'        => $request->amount,
                'qty'           => $request->qty,
                'program_id'    => $request->program_id,
            ]);
            Alert::success('Pemberitahuan', 'Data <b>' . $coupon->code . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $coupon->code . '</b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function edit($id)
    {
        $title = 'Edit Kupon Diskon';
        $coupon = Coupon::find($id);
        $programs = Program::get();

        return view('coupons::edit', compact('title', 'coupon', 'programs'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'            => ['required', 'string', 'max:255'],
            'program_id'    => ['required', 'string', 'max:255'],
            'code'          => ['required', 'string', 'max:255'],
            'amount'        => ['required', 'integer'],
            'qty'           => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        try {
            $coupon = Coupon::find($request->id);
            $coupon->update([
                'program_id'    => $request->program_id,
                'code'          => $request->code,
                'amount'        => $request->amount,
                'qty'           => $request->qty,
            ]);
            Alert::success('Pemberitahuan', 'Data <b>' . $coupon->code . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $coupon->code . '</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return view('coupons::index');
    }

    public function destroy(Request $request)
    {
        try {
            $coupon = Coupon::find($request->id);
            $coupon->delete();
            Alert::success('Pemberitahuan', 'Data <b>' . $coupon->name . '</b> berhasil dihapus')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $coupon->name . '</b> gagal dihapus : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
}
