<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Account;

class AccountController extends Controller
{
    public function index()
    {
    	$results = DB::table("account")->get();
    	return $results;
    }

    public function show($accno, $pin)
    {
    	$results = DB::table("account")->where([['acc_no', '=', $accno], ['pin', '=', $pin]])->first();
    	return $results;
    }

    public function transaksi(Request $request)
    {

        $from = $request->account1;
    	$to = $request->account2;
        $cekAccount = $this->cekAkun($from);
        if ($cekAccount) {
            $jumlah = $this->cekJumlah($request->jumlah, $from);
            if ($jumlah) {
                DB::beginTransaction();
                try {
                    $account1 = DB::table("account")->where('acc_no', $from)->first();
                    $account2 = DB::table("account")->where('acc_no', $to)->first();

                    $total1 = $account1->saldo - $request->jumlah;
                    $total2 = $account2->saldo + $request->jumlah;

                    DB::table('account')->where('acc_no', $account1->acc_no)->update(['saldo' => $total1]);
                    DB::table('account')->where('acc_no', $account2->acc_no)->update(['saldo' => $total2]);

                    $history = array('send_id' => $from, 
                                    'receive_id' => $to,
                                    'amount' =>  $request->jumlah,
                                    'created_at' => date('Y-m-d H:i:s'));

                    $insert_id = DB::table('transaksi')->insertGetId($history);

                    $his_akun1 = array('ref_id_history' => $insert_id, 
                                        'id_akun' => $from,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'trans_type' => "DB",
                                        'saldo' =>  $request->jumlah
                                    );

                    $his_akun2 = array('ref_id_history' => $insert_id,
                                        'id_akun' => $to,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'trans_type' => "CR",
                                        'saldo' =>  $request->jumlah
                                    );

                    DB::table('history_akun')->insert($his_akun1);
                    DB::table('history_akun')->insert($his_akun2);

                    DB::commit();
                    $message = "Berhasil";
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    dd($e);
                    $message = "Gagal";
                }
            }else{
                $message = "Gagal";
            }
        }else{
            $message = "Gagal";
        }

    	return $message;
    }

    public function cekAkun($akun)
    {
        // dd($akun);
        $cek = DB::table('account')->where('acc_no', $akun)->first();
        // dd($cek);
        if (!empty($cek)) {
            return true;
        }else{
            return false;
        }
    }

    public function cekJumlah($jumlah, $from)
    {
        $cek = DB::table('account')->where([['acc_no', '=', $from], ['saldo', '>=', $jumlah]])->first();
        if (!empty($cek)) {
            return true;
        }else{
            return false;
        }
    }
}